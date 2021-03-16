<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cli_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        
        if (! $this->input->is_cli_request()) show_404();
    }

    public function set_output($content)
    {
    	echo $content."\n";
    }
}