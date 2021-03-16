<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Report_model');
		$this->load->library('Pagination');
    }

	public function index()
	{
		$this->shared['submodule'] = 'dashboard';

		$data['title'] = 'Dashboard';
        
		$this->view('admin/dashboard/index', $data);
	}
	
	public function recent_login($order = 0)
	{
		$this->shared['submodule'] = 'dashboard_recent_login';

		$data['page_title'] = 'Recent Login';
	
		$config['base_url'] = site_url('admin/dashboard/recent_login');
		$config['total_rows'] = $this->Report_model->getRecentLogin(5, true);
		$config['per_page'] = 20;

		$this->pagination->initialize($config);
		
        $data['results'] = $this->Report_model->getRecentLogin(5, false, $config['per_page'], $order);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->view('admin/dashboard/recent_login', $data);
    }

}