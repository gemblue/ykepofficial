<?php namespace App\cli\worker;

class WoowaWorker extends BaseWorker {

	public $expire_after = 600; // 10 minutes

	// Required method, will be called by Queue class
	// This method will execute the job
	public function runJob()
	{
		$data = $this->jobData;

		$ci = &get_instance();
		$ci->load->library('bot/Woowa');
		
		$response = $ci->woowa->sendMessage($data['phone_number'], $data);

        return $response;
	}

}