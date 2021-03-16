<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Post_model');
		$this->load->model('Taxonomy_model');
		$this->load->library('pagination');

		$this->shared['submodule'] = 'post';

		// Get post type configuration
		$this->shared['posttypes'] = $this->Post_model->getPostType();
	}

	public function index($status = 'all', $post_type = 'post')
	{
		$this->shared['submodule'] = 'post_'.$post_type;

		if($post_type == 'trash')
			$this->shared['submodule'] = 'post_trash';
                
		$data['page_title'] = $post_type != 'all' ? ucwords($post_type) : 'All Posts';
		$data['status'] = $status;
		$data['type'] = $post_type;
		$data['total'] = $this->Post_model->getPosts($post_type, 'total', $status);
		
		$config['base_url'] = site_url('admin/post/index/'. $status .'/'. $post_type);
		$config['uri_segment'] = 6;
		$config['total_rows'] = $data['total'];
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['results'] = $this->Post_model->getPosts($post_type, 'array', $status, $config['per_page'], $this->uri->segment(6));

		$this->view('admin/post/index', $data);
	}

	public function search()
	{
        $get = $this->input->get();
        
        $data['page_title'] = make_label($get['type']);
        $data['search_mode'] = true;
        $data['keyword'] = $get['keyword'];
        $data['type'] = $get['type'];
        $data['status'] = $get['status'];
        $data['total'] = $this->Post_model->searchPosts($get['keyword'], $get['type'], 'total', $get['status']);
		$data['results'] = $this->Post_model->searchPosts($get['keyword'], $get['type'], 'list', $get['status']);
		
		$this->view('admin/post/index', $data);
	}

	public function add_type()
	{
		$data['page_title'] = 'Custom Type';

		$this->view('admin/post/add_type', $data);
    }

	public function add($post_type = 'post')
	{
        if ($post_type == 'all')
            $post_type = 'post';

        $data = [
            'page_title' => 'New ' . make_label($post_type),
            'form_type' => 'new',
            'post_type' => $post_type,
		    'templates' => $this->template->get_available_templates(),
            'categories' => $this->Taxonomy_model->get_all($post_type . '_category'),
        ];

		$this->view('admin/post/form', $data);
	}

	public function edit($post_id)
	{
        // Get previous data.
        $result = $this->Post_model->getPost(null, 'id', $post_id);
		
        if (isset($result->type))
            $type = $result->type;
        else
            $type = 'Unknown';

        $data = [
            'page_title' => make_label($type),
            'form_type' => 'edit',
            'result' => $result,
            'post_type' => $type,
            'category' => $this->Taxonomy_model->get_category($post_id),
		    'categories' => $this->Taxonomy_model->get_all($type . '_category'),
            'tags' => $this->Taxonomy_model->get_tags($post_id, 'string'),
            'templates' => $this->template->get_available_templates(),
            'meta' => $this->Post_model->getMeta($result->type, $post_id)
        ];
        
		$this->view('admin/post/form', $data);
	}

	public function update()
	{
        $post = $this->input->post();

		// $old = $this->Post_model->getPost(null, 'id', $post['post_id'], 'array');

        $data = [
            'category_id' => $post['category_id'] ?? null,
			// 'status' => $post['status'],
			'post_type' => $post['post_type'],
            'title' => $post['title'],
            'featured_image' => $post['featured_image'],
            'embed_video' => $post['embed_video'],
            'template' => $post['template'],
			'content' => $post['content'],
			'content_type' => $post['content_type'] ?? 'markdown',
			'author' => $this->session->userdata('user_id'),
			'slug' => $post['slug'],
			'tags' => $post['tags'],
			'featured' => $post['featured']
        ];

        // if($old['status'] == 'draft' && $post['status'] = 'publish')
	       //  $data['published_at'] = date('y-m-d h:i:s');

        $update = $this->Post_model->update($post['post_id'], $data);

	    // Save post meta if exist
        if ($post['meta'] ?? null)
            $this->Post_model->updateMeta($post['post_type'], $post['post_id'], $post['meta']);
        
        if ($update['status'] == 'failed') {
            
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => $update['message']]);
            exit;

        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => $update['message']]);
        exit;
    }

	public function insert()
	{
		$post = $this->input->post();
		
		$insert = $this->Post_model->insert([
			'category_id' => $post['category_id'] ?? null,
			// 'status' => $post['status'],
			'post_type' => $post['post_type'] ?? 'post',
            'title' => $post['title'],
            'featured_image' => $post['featured_image'],
            'embed_video' => $post['embed_video'],
            'template' => $post['template'],
			'content' => $post['content'],
			'content_type' => $post['content_type'] ?? 'markdown',
			'author' => $this->session->userdata('user_id'),
			'slug' => $post['slug'],
			'tags' => $post['tags']
		]);
		
		if ($insert['status'] == 'failed') 
        {    
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => $insert['message']]);
            exit;
        }

		// Save post meta if exist
        if ($post['meta'] ?? null)
            $this->Post_model->updateMeta($post['post_type'], $insert['inserted_id'], $post['meta']);
		
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => $insert['message'], 'id' => $insert['inserted_id']]);
        exit;

	}

	public function preview()
	{
		$post_type =  $this->input->post('type', TRUE);
		$this->url_source =  $this->input->post('url_source', TRUE);
		$category_id = $this->input->post('category_id', TRUE);
		$current_category_id = $this->input->post('current_category_id', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$created_at = $this->input->post('created_at', TRUE);
		$featured_image = $this->input->post('featured_image', TRUE);

		// Category id control
		if (empty($category_id))
		{
			$category_id = $current_category_id;
		}

		// Slug check
		if ($this->Post_model->isExist('slug', $slug))
		{
			$this->session->set_flashdata('message', $this->lang->line('mein_error_slug'));
			redirect($this->url_source);
		}
		else
		{
			$param = array (
				'category_id' => $category_id,
				'status' => 'preview',
				'type' => $post_type,
				'title' => $this->input->post('title', TRUE),
				'created_at' => $created_at,
				'content' => $this->input->post('content', TRUE),
				'author' => $this->shared['user_id'],
				'slug' => $slug,
				'tags' => $this->input->post('tags', TRUE)
			);

			if ($this->Post_model->insert_post($param))
			{
				$post_id = $this->Post_model->get_post_id($slug);

				// Take and update new field extra
				foreach ($_POST as $name => $val)
				{
					$name = htmlspecialchars($name);
					$val = htmlspecialchars($val);

					$not_allowed_field = array('url_source', 'post_id', 'content', 'current_category_id', 'status', 'type', 'category_id', 'created_at', 'slug', 'tags', 'title' , 'author', 'created_at');

					if (!in_array($name, $not_allowed_field))
					{
						$exploded = explode('-', $name);

						// Update meta
						$this->Post_model->update_meta($exploded[1], $post_type, $exploded[0], $val, $post_id, 'preview');
					}
				}

				// Update post/page template
				$this->Post_model->update_meta('post_template', 'page', 'text', $this->input->post('text-post_template'), $post_id, 'preview');

				echo $slug;
			}
		}
	}
	
	public function delete($post_id)
	{
		$result = $this->Post_model->getPost(null, 'id', $post_id);

		$this->Post_model->delete($post_id);
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
        
        redirect($this->input->get('callback'));
	}
	
	public function trash($post_id)
	{
		$result = $this->Post_model->getPost(null, 'id', $post_id);
		
		/** ACL */
        if (!isPermitted('forum/reply/edit', 'post', [$result->author])) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">You have no privilege to perform this.</div>');
			redirect($_SERVER['HTTP_REFERER']);
        }

		$this->Post_model->trash($post_id);
        
        $this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
        
        redirect($this->input->get('callback'));
	}

	public function restore($post_id)
	{
		$this->Post_model->restore($post_id);
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
        
        redirect($this->input->get('callback'));
	}

	public function publish($post_id)
	{
		$this->Post_model->publish($post_id);

		// Send FCM notification
		$this->sendFcmNotification($post_id);
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
        
        redirect($this->input->get('callback'));
	}

	public function draft($post_id)
	{
		$this->Post_model->draft($post_id);
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
        
        redirect($this->input->get('callback'));
    }

    public function sendFcmNotification($id)
    {
        $post = $this->Post_model->getPost(null, 'id', $id, 'array');
        if(!$post)
        	$this->response('Post not found', self::HTTP_NOT_FOUND);

		if(strpos($post['featured_image'], 'http') === false){
        	$this->load->helper('files/filemanager');
        	$post['featured_image'] = get_file_url($post['featured_image']);
        }
        $post['category'] = $this->Taxonomy_model->get_category($post['id']);
		$post['url'] = site_url('api/post/'.$post['id']);

		unset($post['content']);

		$topic = $post['type'] == 'post' ? 'articles' : 'articles-'.$post['type'];
	    $topic .= $_ENV['CI_ENV'] == 'production' ? '' : '-staging';

	    $fcm = new App\modules\notification\libraries\Fcm;
	    $response = $fcm->push(['post' => $post], $topic);
    }
}
