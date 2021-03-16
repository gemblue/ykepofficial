<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
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

		$this->load->model('Report_model');

		$data['page_title'] = 'Recent Login';
	
		$config['base_url'] = site_url('admin/dashboard/recent_login');
		$config['total_rows'] = $this->Report_model->getRecentLogin(5, true);
		$config['per_page'] = 20;

		$this->pagination->initialize($config);
		
        $data['results'] = $this->Report_model->getRecentLogin(5, false, $config['per_page'], $order);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->view('admin/dashboard/recent_login', $data);
    }

	public function selling()
	{
		$this->shared['submodule'] = 'dashboard_selling';

		$this->load->model('Report_model');
		$this->load->model('payment/Order_model');
		$this->load->model('product/Product_model');

		// Handle date ..
		$data['start'] = $this->input->get('start');
		$data['end'] = $this->input->get('end');

		if (empty($data['start'])) {
            $data['start'] = date('Y-m-d', strtotime('-6 days'));
		} 

		if (empty($data['end'])) {
			$data['end'] = date('d M Y', strtotime('1 days'));
		}
		
		// Ok.
		$data['title'] = 'Selling';
		$data['products'] = $this->Product_model->where('retail_price !=', 0)->get_all();
		$data['free_products'] = $this->Product_model->where('retail_price', 0)->get_all();
		$data['total_transaction'] = $this->Report_model->getTotalTransaction($data['start'], $data['end']);
		$data['total_selling'] = $this->Report_model->getTotalSelling($data['start'], $data['end']);
		
        $this->view('admin/dashboard/selling', $data);
    }

}
