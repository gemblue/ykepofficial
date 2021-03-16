<?php namespace App\cli\worker;

class TelegramWorker extends BaseWorker {

	public $expire_after = 600; // 10 minutes

	// Required method, will be called by Queue class
	// This method will execute the job
	public function runJob()
	{
		$data = $this->jobData;

		$ci = &get_instance();
		$ci->load->library('bot/telegrambot');
		
		$response = $ci->telegrambot->sendMessage($data['botname'], $data['chat_id'], $data);

        return $response;
	}

}