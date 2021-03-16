<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends Backend_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Taxonomy_model');
        $this->load->library('pagination');

        $this->shared['submodule'] = 'post_tags';
	}

	public function index()
	{
		$data['page_title'] = 'Tags';
		$data['total'] = $this->Taxonomy_model->get_total('tag');

		$config['base_url'] = site_url('admin/tags');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
        
        $data['pagination'] = $this->pagination->create_links();
        $data['results'] = $this->Taxonomy_model->get_all('tag', $config['per_page'], $this->uri->segment(3));

		$this->view('admin/tags/index', $data);
	}

	public function add()
	{
		$data['page_title'] = 'New Tags';
        $data['form_type'] = 'new';

		$this->view('admin/tags/form', $data);
	}

	public function edit($id)
	{
		$data['page_title'] = 'Edit Tag';
        $data['form_type'] = 'edit';
        $data['post_type'] = null;
        $data['result'] = $this->Taxonomy_model->get_detail($id);
        
		$this->view('admin/tags/form', $data);
	}
    
	public function update()
	{
		$id = $this->input->post('id');
        
		$this->Taxonomy_model->update($id, [
			'name' => $this->input->post('name'),
			'slug' => $this->input->post('slug')
        ]);
        
		$this->session->set_flashdata('message', $this->lang->line('mein_success_update'));
        
        redirect('admin/post/tags/edit/' . $id);
	}

	public function delete($id)
	{
		$this->Taxonomy_model->delete($id);
        
        $this->session->set_flashdata('message', $this->lang->line('mein_success_delete'));
        
        redirect('admin/post/tags/index');
	}

	public function search()
	{
        $keyword = $this->input->post('keyword');

		$data['page_title'] = 'Search Tags';
		$data['total'] = $this->Taxonomy_model->search_total('tag', $keyword);
        
		$config['base_url'] = site_url('admin/post/tags');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
        
        $data['pagination'] = $this->pagination->create_links();
        $data['results'] = $this->Taxonomy_model->search('tag', $keyword, $config['per_page'], $this->uri->segment(3));
        
		$this->view('admin/tags/index', $data);
	}
}