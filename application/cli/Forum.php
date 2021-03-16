<?php 

namespace App\cli;

class Forum {

	public function __construct()
	{
        ci()->output->enable_profiler(false);
        ci()->load->library('bot/telegrambot');;
	}

	/**
     * Notif
     * 
     * Notif unanswered thread ..
     * 
     * @return json
     */
    public function notifUnansweredThread()
    {
		$yesterday = date('Y-m-d', strtotime('-1 days')); // Yesterday
		
        // Get this month Unanswered.
        ci()->db->select('*');
        ci()->db->from('forum_thread');
        ci()->db->where('total_answer', 0);
		ci()->db->where('thread_status', 'publish');
		ci()->db->where('thread_mark', 'opened');
		ci()->db->where('created_at >=', $yesterday);
		
		$threads = ci()->db->get()->result();
        
        $total = 0;
        if (!empty($threads)) 
        {
            $total = count($threads);
            $message = null;

            foreach($threads as $thread)
                $message .= 'https://www.codepolitan.com/forum/thread/detail/' . $thread->id . '/' . $thread->thread_slug . "\n\n";
            
            // Send to Codepolitan Support.
            ci()->telegrambot->sendMessageToGroup('group_support', ['message' => "*[Thread Unanswered]* Hai kak, ada " . $total . " belum dijawab di forum nih. Threads : \n\n" . $message]);
        }

        ci()->output->set_header('content-type','application/json')
                     ->_display(json_encode(['status' => 'success', 'total' => $total, 'message' => 'Successfully processed.']));
    }

}