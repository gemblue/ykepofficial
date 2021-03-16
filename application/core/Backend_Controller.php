<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        
        $this->load->model('Entry_model');

        // Set admin theme and default layout
        $this->template->setTheme($this->config->item('template.admin_theme'), true);

        $this->load->model('page/Page_model');
        $this->config->set_item('plugins', $this->Page_model->pluginList());
        
        // Do not parse admin template
        $this->load->parseContent(false);
    }
}
