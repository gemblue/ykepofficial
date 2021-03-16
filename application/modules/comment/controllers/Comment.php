<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Cmt_model');
        $this->load->model('Cmt_reply_model');
        $this->load->model('Cmt_jail_model');
        $this->load->model('notification/Notification_model');
        $this->load->model('notification/Room_model');
    }

    /**
     * Show comment home.
     */
	public function index()
	{
        $this->output->enable_profiler(false);
        
        $data['identity'] = $this->input->get('identity');
        $data['subject'] = $this->input->get('subject');
        $data['slug'] = $this->input->get('slug');
        $data['in_room'] = $this->Room_model->isInRoom($data['identity'], $this->session->user_id);
        
        $data['replies'] = $this->Cmt_reply_model->with_user()->where([
            'identity' => $data['identity'],
            'reply_status' => 'publish'
        ])->order_by('created_at', 'desc')->get_all();
        
        if (!empty($data['replies']))
            $data['total'] = count($data['replies']);
        
        $this->load->render('home', $data);
    }

    /**
     * Subscribe/Unsubscribe
     */
	public function subscribe()
	{
        if ($this->Room_model->isInRoom($this->input->post('identity'), $this->session->user_id)) 
        {
            $this->Room_model->remove($this->input->post('identity'), $this->session->user_id);
            
            header('Content-type: application/json');
            echo json_encode(['status' => 'success', 'in_room' => false]);
            exit;
        } 
        else 
        {
            $this->Room_model->push($this->input->post('identity'), $this->session->user_id);
            
            header('Content-type: application/json');
            echo json_encode(['status' => 'success', 'in_room' => true]);
            exit;
        }
    }

	/**
     * Insert comment
     */
	public function insert()
	{
        $post = $this->input->post(null, true);
        $subject = $post['subject'];
        $slug = $post['slug'];

        // Harus login dulu.
        if (!$this->shared['me'])
        {
            header('Content-type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Kamu harus <a target="_blank" href="'. site_url('user/login?callback=') . site_url($slug) .'">login</a> dulu untuk mengomentari halaman ini']);
            exit;
        }

        unset($post['subject']);
        unset($post['slug']);

        $post['user_id'] = $this->session->user_id;
        $post['comment_status'] = 'publish';
        
        $this->Cmt_model->set_form_data($post);
        $this->Cmt_model->validate();
        
        // Spam check
        $spam = $this->Cmt_jail_model->checkSpam($this->session->user_id, 'comment');
        
        if ($spam['status'] == 'failed')
        {
            header('Content-type: application/json');
            echo json_encode(['status' => 'failed', 'message' => $spam['message']]);
            exit;
        }

        if ($this->Cmt_model->insert()) 
        {
            // Trigger notif ..
            $this->Notification_model->push([
                'message' => $this->session->fullname . ' mengomentari artikel <b>'. $subject . '</b>', 
                'uri' => $slug,
                'room' => $post['identity'],
                'user_id' => $this->session->user_id,
                'type' => 'comment'
            ]);
            
            header('Content-type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Successfully inserted']);
            exit;
        }

        header('Content-type: application/json');
        echo json_encode(['status' => 'failed', 'message' => validation_errors()]);
        exit;
    }

    /**
     * Update comment
     */
	public function update()
	{
        $post = $this->input->post(null, true);
        $comment = $this->Cmt_model->where('id', $post['id'])->get();
        
        // ACL
        if (!isPermitted('comment/update', 'comment', [$comment['user_id']])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Kamu tidak bisa melakukan hal ini.</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Inject
        $post['comment_status'] = 'publish';
        
        $this->Cmt_model->set_form_data($post);
        $this->Cmt_model->validate();
        
        if ($this->Cmt_model->updateComment($post)) 
        {
            header('Content-type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Successfully updated']);
            exit;
        }

        header('Content-type: application/json');
        echo json_encode(['status' => 'failed', 'message' => validation_errors()]);
        exit;
    }

    /**
     * Delete comment
     */
	public function remove()
	{
        $post = $this->input->post(null, true);
        $comment = $this->Cmt_model->where('id', $post['id'])->get();
        
        // ACL
        if (!isPermitted('comment/remove', 'comment', [$comment['user_id']])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Kamu tidak bisa melakukan hal ini.</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($this->Cmt_model->delete($post['id'])) {
            header('Content-type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Successfully deleted']);
            exit;
        }
        
        header('Content-type: application/json');
        echo json_encode(['status' => 'failed', 'message' => validation_errors()]);
        exit;
    }
}