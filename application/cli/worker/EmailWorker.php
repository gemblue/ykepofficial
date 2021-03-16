<?php namespace App\cli\worker;

class EmailWorker extends BaseWorker {

	public $expire_after = 180; // 3 minutes

	// Required method, will be called by Queue class
	// This method will execute the job
	public function runJob()
	{
		$data = $this->jobData;

		$ci = &get_instance();
		$ci->load->helper('email');

		$response = sendEmail($data['to'], $data['subject'], $data['data'], $data['template']);

		if($response){
			$output['status'] = "success";
			$output['message'] = "Email sent";
		} else {
			$output['status'] = "failed";
			$output['message'] = "email fail to send";
		}

        return json_encode($output);
	}
}