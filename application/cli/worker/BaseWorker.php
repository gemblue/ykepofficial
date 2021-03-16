<?php namespace App\cli\worker;

abstract class BaseWorker {

	public $expire_after = 300; // 5 minutes in seconds
	protected $jobData;

	public function __construct($data)
	{
		$this->jobData = $data;
	}

	public function runJob()
	{
		print_r($this->jobData);
	}

}