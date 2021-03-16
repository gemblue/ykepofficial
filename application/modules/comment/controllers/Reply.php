<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Cmt_reply_model');
        $this->load->model('Cmt_jail_model');
        $this->load->model('notification/Notification_model');
        $this->load->model('notification/Room_model');
    }

	/**
     * Insert reply
     */
	public function insert()
	{
        $post = $this->input->post(null, true);
        $subject = $post['subject'];
        $slug = $post['slug'];
        
        // Harus login dulu
        if (!$this->shared['me'])
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Kamu harus <a target="_blank" href="'. site_url('user/login?callback='. site_url($slug)) .'">login</a> terlebih dahulu untuk menjawab.</div>');        
            redirect(getenv('HTTP_REFERER'));
        }
        
        unset($post['subject']);
        unset($post['slug']);

        $post['user_id'] = $this->session->user_id;
        $post['reply_status'] = 'publish';
        $post['reply_mark'] = NULL;
        $post['reply_content'] = $this->input->post('reply_content');
        
        $this->Cmt_reply_model->set_form_data($post);
        $this->Cmt_reply_model->validate();
        
        // Spam check
        $spam = $this->Cmt_jail_model->checkSpam($this->session->user_id, 'comment_reply');
        
        if ($spam['status'] == 'failed')
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $spam['message'] .'</div>');        
            redirect(getenv('HTTP_REFERER'));
        }

        if ($this->Cmt_reply_model->insert()) 
        {
            // Trigger notif ..
            $this->Notification_model->push([
                'message' => $this->session->fullname . ' membalas artikel <b>'. $subject . '</b>', 
                'uri' => $slug,
                'room' => $post['identity'], 
                'user_id' => $this->session->user_id,
                'type' => 'comment'
            ]);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully replied.</div>');
            redirect(getenv('HTTP_REFERER'));
        }

        $this->session->set_flashdata('message', '<div class="alert alert-danger">'. validation_errors() .'</div>');        
        redirect(getenv('HTTP_REFERER'));
    }

    /**
     * Update reply
     */
	public function update()
	{
        $post = $this->input->post(null, true);
        
        $reply = $this->Cmt_reply_model->where('id', $post['id'])->get();
        
        // Don't clean thread content
        $post['reply_content'] = $this->input->post('reply_content');
        
        if ($this->Cmt_reply_model->updateReply($post))
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
     * Remove
     */
    public function remove()
    {
        $get = $this->input->get(null, true);

        $reply = $this->Cmt_reply_model->get($get['reply_id']);
        
        if (empty($reply))
            show_404();
        
        $this->Cmt_reply_model->delete($get['reply_id']);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully removed.</div>');
        redirect(getenv('HTTP_REFERER'));
        
        show_404();
    }
}