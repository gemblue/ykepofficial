<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Backend_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Taxonomy_model');
        $this->load->library('pagination');

        $this->shared['submodule'] = 'post_category';
	}

	public function index($post_type = 'post')
	{
		$data['page_title'] = make_label($post_type) . ' Category';
		$data['post_type'] = $post_type;
        $data['total'] = $this->Taxonomy_model->get_total($post_type . '_category');
        
        // Pagination
		$config['base_url'] = site_url('admin/post/category/' . $post_type);
		$config['total_rows'] = $data['total'];
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		
        $this->pagination->initialize($config);
        
        $data['pagination'] = $this->pagination->create_links();
        $data['results'] = $this->Taxonomy_model->get_all($post_type . '_category', $config['per_page'], $this->uri->segment(4));

		$this->view('admin/category/index', $data);
    }
    
    public function search($post_type = 'post')
	{
		$data['page_title'] = make_label($post_type) . ' Category';
		$data['post_type'] = $post_type;
        $data['results'] = $this->Taxonomy_model->search($post_type . '_category', $this->input->get('keyword'));

		$this->view('admin/category/index', $data);
	}

	public function add($post_type = 'post')
	{
		$data = [
            'page_title' => 'New ' . ucfirst($post_type) .' Category',
		    'form_type' => 'new',
		    'post_type' => $post_type,
        ];

		$this->view('admin/category/form', $data);
	}
    
    public function edit($id)
	{
		$data['page_title'] = 'Edit Category';
        $data['form_type'] = 'edit';
		$data['post_type'] = null;
        $data['result'] = $this->Taxonomy_model->get_detail($id);
        
		$this->view('admin/category/form', $data);
	}

	public function insert()
	{ 
        /**
         * If reques is ajax ..
         */
        if ($this->input->is_ajax_request())
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required')
                                  ->set_rules('slug', 'Slug', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Name or slug are required']);
                exit;
            }

            $post = $this->input->post();

            $insert = $this->Taxonomy_model->insert($post['post_type'] . '_category', ['name' => $post['name'], 'slug' => $post['slug']]);
            
            if ($insert['status'] == 'failed')
            {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => $insert['message']]);
                exit;
            }

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Successfully added ..', 'term_id' => $insert['term_id']]);
            exit;
        }

        /**
         * Normal.
         */

        $post = $this->input->post();

        $insert = $this->Taxonomy_model->insert($post['post_type'] . '_category', ['name' => $post['name'], 'slug' => $post['slug']]);
        
        if ($insert['status'] == 'failed')
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $insert['message'] .'</div>');
            redirect('admin/post/category/add/' . $post['post_type']);
        }
        
		$this->session->set_flashdata('message', '<div class="alert alert-success">'. $insert['message'] .'</div>');
		
        redirect('admin/post/category');
	}

	public function update()
	{
		$post = $this->input->post();
        
		$update = $this->Taxonomy_model->update($post['id'], ['name' => $post['name'], 'slug' => $post['slug']]);
        
        if ($update['status'] == 'failed')
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $update['message'] .'</div>');
        else
		    $this->session->set_flashdata('message', '<div class="alert alert-success">'. $update['message'] .'</div>');
        
        if($this->input->post('btnSaveExit'))
	        redirect('admin/post/category');

	    redirect('admin/post/category/edit/' . $post['id']);
	}

	public function delete($id)
	{
		$this->Taxonomy_model->delete($id);
        
        $this->session->set_flashdata('message', $this->lang->line('mein_success_delete'));
        
        redirect('admin/post/category');
	}
}
