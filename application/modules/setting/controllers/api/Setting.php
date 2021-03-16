<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends REST_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	// Detail riwayat pembayaran
	public function detail($setting_name)
    {
    	$value = setting_item($setting_name);

    	if($value)
	    	$this->response(['status' => 'success', 'name' => $setting_name, 'value' => $value]);
	    else
	    	$this->response(['status' => 'failed', 'message' => 'Setting item not found', 'status_code' => REST_Controller::HTTP_NOT_FOUND]);

    }

}
