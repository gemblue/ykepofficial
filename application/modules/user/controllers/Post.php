<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->library('ci_auth');
        $this->load->library('pagination');

        $this->load->model('Post/Post_model');
        $this->load->model('Post/Taxonomy_model');
        
        // Yang boleh akses yang login saja.
        if (!$this->ci_auth->isLoggedIn())
            redirect('user/login');
    }
    
    /**
     * Show user posts
     * 
     * @return mixed
     */
    public function index()
	{
        if ($this->input->get('status')) {
            $status = $this->input->get('status');
        } else {
            $status = 'all';
        }

        if ($this->input->get('type')) {
            $type = $this->input->get('type');
        } else {
            $type = 'all';
        }
        
        // Get posts by user.
        $data['page_title'] = 'My Posts';
		$data['status'] = $status;
        $data['type'] = $type;
		$data['total'] = $this->Post_model->getPosts($type, 'total', $status, null, null, null, null, null, $this->session->username);
		
		$config['base_url'] = site_url('user/post?status='. $status .'&type='. $type);
		$config['uri_segment'] = 3;
		$config['total_rows'] = $data['total'];
        $config['per_page'] = 10;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['results'] = $this->Post_model->getPosts($type, 'array', $status, $config['per_page'], $this->input->get('page'), 'created_at', 'desc', 'stdClass', $this->session->username);
        
        $this->load->render('user/post/index', $data);
    }

    /**
     * Show form add post.
     * 
     * @return mixed
     */
    public function add($type = 'post')
	{
        $data = [
            'page_title' => 'New Posts',
            'post_type' => $type,
            'tags' => null,
            'categories' => $this->Taxonomy_model->get_all($type . '_category')
        ];

        /**
         * Post action
         */
        if ($post = $this->input->post()) 
        {
            foreach($post as $key => $value)
                $this->session->set_flashdata($key, $value);
            
            $insert = $this->Post_model->insert([
                'category_id' => isset($post['category_id']) ? $post['category_id'] : null,
                'status' => 'draft',
                'post_type' => $type,
                'title' => $post['title'],
                'content' => $post['content'],
                'author' => $this->session->user_id,
                'slug' => slugify($post['title']),
                'tags' => $post['tags'],
                'featured_image' => $post['featured_image']
            ]);
            
            if ($insert['status'] == 'failed')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $insert['message'] . '</div>');
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Update event meta ..
            if ($post['post_type'] == 'event') {
                $this->Post_model->updateMeta($insert['inserted_id'], $post['event']);
            }
            
            $this->session->set_flashdata('message', '<div class="alert alert-success">' . $insert['message'] . '</div>');
            redirect('user/post/edit/' . $insert['inserted_id']);
        }
        
        $this->load->render('user/post/form', $data);
    }

    /**
     * Show form edit post.
     * 
     * @return mixed
     */
    public function edit($id)
	{
        $post = $this->Post_model->getPost(null, 'id', $id);
        
        if (empty($post))
            show_404();
        
        $data = [
            'page_title' => 'Edit Posts',
            'post' => $post,
            'post_type' => $post->type,
            'category' => $this->Taxonomy_model->get_category($id),
            'categories' => $this->Taxonomy_model->get_all($post->type . '_category'),
		    'tags' => $this->Taxonomy_model->get_tags($id, 'string'),
        ];
        
        /**
         * Post action
         */
        if ($post = $this->input->post()) 
        {
            foreach($post as $key => $value)
                $this->session->set_flashdata($key, $value);

            $update = $this->Post_model->update($post['post_id'], [
                'category_id' => $post['category_id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'tags' => $post['tags'],
                'slug' => slugify($post['title']),
                'post_type' => 'post',
                'author' => $this->session->user_id,
                'featured_image' => $post['featured_image']
            ]);
            
            if ($update['status'] == 'failed') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $update['message'] . '</div>');
            } else {
                // Update event meta ..
                if ($post['post_type'] == 'event') {
                    $this->Post_model->updateMeta($post['post_id'], $post['event']);
                }
                
                $this->session->set_flashdata('message', '<div class="alert alert-success">' . $update['message'] . '</div>');
            }

            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->render('user/post/form', $data);
    }
    
    /**
     * Ready to review
     * 
     * @return mixed
     */
    public function review($id)
	{
        $this->Post_model->review($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully changed ..</div>');
        
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Remove
     * 
     * @return mixed
     */
    public function remove($id)
	{
        // Yang boleh delete yang punya aja dan yang draft aja.
        $post = $this->Post_model->getPost(null, 'id', $id);
        
        if (empty($post))
            show_404();

        if ($post->author == $this->session->user_id && $post->status == 'draft')
        {
            $this->Post_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully removed ..</div>');
            
            redirect($_SERVER['HTTP_REFERER']);
        } 

        show_404();
    }
}