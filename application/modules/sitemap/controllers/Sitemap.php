<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('page/Page_model');
		$this->output->enable_profiler(false);
	}

	public function index()
	{
		$data['pages'] = $this->getPages();
		$data['posts'] = $this->getPosts();

		header("Content-Type: text/xml;charset=iso-8859-1");
		$this->load->view('index', $data);
	}

	private function getPosts()
	{
		return $this->db->select('slug')
					->from('mein_posts')
					->where('status','publish')
					->get();
	}

	private function getPages($data = [])
	{
		if(empty($data))
			$data = $this->Page_model->scan_pages();

		$result = [];
		foreach ($data as $page) {
			$result[] = $page['url'];
			if(isset($page['children']))
				$result = array_merge($result, $this->getPages($page['children']));
		}

		return $result;
	}

}