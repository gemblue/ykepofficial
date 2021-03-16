<?php 

namespace App\cli;

class Queue {

	private $jobs;
	private $workers = [];

	// You may call this method from command line or cron
	public function runJobs()
	{
		$limit = config_item('queue.limit_job') ?? 10;

		if (! $this->_initWorkers($limit)) {
			die("No job to do. \n");
		}

		foreach ($this->workers as $jobID => $worker) 
		{
			$startTime = microtime(true);
			$response = $worker->runJob();
			$responseArray = json_decode($response, true);
			$total = 0;

			if (!$responseArray || $responseArray && $responseArray['status'] == 'success') 
			{
				$costSeconds = number_format(microtime(true) - $startTime, 2, '.', '');
				$this->_setJobDone($jobID, $costSeconds);
			}
			elseif ($responseArray && $responseArray['status'] == 'failed') 
			{
				$this->_requeueJob($jobID);
			}

			if (!empty($responseArray)) {
				$total = count($responseArray);
			}

			echo "Running $total job. Please wait \n";
		}
	}

	public function placeQueue($type, $payload = [], $priority = 9, $expire_after = null)
	{
		$ci = &get_instance();

		$data = [
			'type' => $type,
			'payload' => json_encode($payload),
			'priority' => $priority,
		];

		$className = "App\cli\worker\\".ucfirst($type).'Worker';
		$worker = new $className($payload);

		if(is_int($expire_after))
			$data['expired_at'] = date('Y-m-d H:i:s', time() + $expire_after);
		else
			$data['expired_at'] = date('Y-m-d H:i:s', time() + $worker->expire_after);

		$ci->db->insert('jobs', $data);
		return $ci->db->insert_id();
	}

	private function _initWorkers($limit = 5)
	{
		$ci = &get_instance();

		$this->jobs = $ci->db
						 ->where('status', 'queued')
						 ->where('attempt <', '3')
						 ->where('(expired_at is null OR expired_at > now())', null)
						 ->limit($limit)
						 ->order_by('priority', 'asc')
						 ->order_by('id', 'asc')
						 ->get('jobs')->result_array();

		if(empty($this->jobs)) return false;

		// Set status to running
		$ids = array_column($this->jobs, 'id');
		$this->_setJobRunning($ids);

		// Create job
		foreach ($this->jobs as $job) {
			$className = "App\cli\worker\\".ucfirst($job['type']).'Worker';
			$this->workers[$job['id']] = new $className(json_decode($job['payload'],true));
		}

		return true;
	}

	private function _setJobRunning($jobIDs = [])
	{
		$ci = &get_instance();

		$ci->db->where_in('id', $jobIDs)->update('jobs', ['status'=>'running']);
		return $ci->db->affected_rows();
	}

	private function _setJobDone($jobID, $costSeconds = null)
	{
		$ci = &get_instance();

		$ci->db->where('id', $jobID)->update('jobs', ['status'=>'done', 'run_time' => $costSeconds]);
		return $ci->db->affected_rows();
	}

	private function _requeueJob($jobID)
	{
		$ci = &get_instance();

		$ci->db->set('status','queued');
		$ci->db->set('attempt','attempt + 1', false);
		$ci->db->where('id', $jobID)->update('jobs');
		return $ci->db->affected_rows();
	}

}