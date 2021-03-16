<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_title'] = 'File Manager';

		$this->view('admin', $data);
	}
}
