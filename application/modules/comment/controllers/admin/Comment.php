<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends Backend_Controller {

    public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Cmt_reply_model');
        $this->load->model('Cmt_jail_model');
    	$this->load->model('post/Post_model');
    	$this->load->library('pagination');

    	$this->shared['submodule'] = 'comment';
	}

	public function index($pagenum = 1)
	{
        $data['page_title'] = 'Comments';
        
        $perpage = 20;
        $total_rows = $this->Cmt_reply_model->setFilter()->count_rows();
        $uri     = 'admin/quiz/question/index/';
        
        $data['fields'] = $this->Cmt_reply_model->fields;
        
        $data['results'] = $this->Cmt_reply_model->setFilter()
                                ->with_user()
                                ->order_by('created_at', 'desc')
                                ->paginate($perpage, $total_rows, $pagenum, $uri);
        $data['pagination'] = $this->Cmt_reply_model->all_pages;
        $data['total'] = $total_rows;
        
        $this->view('admin/comment/index', $data);
	}

	public function jailed($pagenum = 0)
	{
		$this->shared['submodule'] = 'comment_jailed';

		$data['page_title'] = 'Jailed Users';

		$config = [
			'base_url' => site_url('admin/comment/comment/jailed'),
			'total_rows' => $this->Cmt_jail_model->getJailedUsers(null, null, true),
			'per_page' => 20
		];

		$this->pagination->initialize($config);
		
        $data['results'] = $this->Cmt_jail_model->getJailedUsers($config['per_page'], $pagenum);
		$data['pagination'] =  $this->pagination->create_links();
		$data['total'] =  $config['total_rows'];
		
        $this->view('admin/comment/jailed', $data);
	}

	public function set_free($id)
	{
		$this->Cmt_jail_model->setFree($id);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function jail($id)
	{
		$this->Cmt_jail_model->jail($id);

		redirect($_SERVER['HTTP_REFERER']);
	}
}