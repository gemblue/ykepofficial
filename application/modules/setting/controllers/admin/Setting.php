<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

class Setting extends Backend_Controller {

	public function __construct()
	{
        parent::__construct();
    }
    
	public function index()
	{
		$data['page_title'] = 'Setting';

        $data['modules_setting'] = module_setting();
        $data['entries_setting'] = entry_setting();
        $data['shared_setting'] = site_setting();
        $data['plugin_setting'] = plugin_setting();
        
		$this->view('admin/form', $data);
	}

	public function update()
	{        
        $module_setting = module_setting();

        $data = $this->input->post();

        $entry = [];
        foreach ($data as $module => $items) {
	        foreach ($items as $key => $value) {
	        	$entry[] = [
	        		'option_group' => $module,
	        		'option_name' => $key,
	        		'option_value' => $value
	        	];
    	    }
        }

        $this->Setting_model->updateBatch($entry);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Sucessfully Updated.</div>');
        
		redirect('admin/setting');
    }

}
