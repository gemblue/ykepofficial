<?php namespace App\cli\worker;

class SampleWorker extends BaseWorker {

	// Required method, will be called by Queue class
	// This method will execute the job
	public function runJob()
	{
		$data = $this->jobData;

		$ci = &get_instance();
		$ci->load->helper('file');
		
		$response = write_file('./uploads/'.$data['filename'], $data['content']);

		if($response){
			$output['status'] = "success";
			$output['message'] = "file created";
		} else {
			$output['status'] = "failed";
			$output['message'] = "file fail to create";
		}

        return json_encode($output);
	}
}