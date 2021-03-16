<?php 

namespace App\cli;

class Payment {

	public function __construct()
	{
        ci()->output->enable_profiler(false);
        ci()->load->model('payment/Order_model');
	}

	/**
     * Clean
     * 
     * Cleaning expired transaction.
     * 
     * @return bool
     */
    public function cleanOrder()
    {
        if (ci()->Order_model->cleanOrder()) {
            ci()->output->set_header('content-type','application/json')
                         ->_display(json_encode(['output' => 'Successfully cleaned']));
        } else {
            ci()->output->set_header('content-type','application/json')
                         ->_display(json_encode(['output' => 'No one to clean']));
        }
    }

    /**
     * FollowUp
     * 
     * FollowUp
     * 
     * @return bool
     */
    public function followUp()
    {
        $followup = ci()->Order_model->followUp();
        
        ci()->output->set_header('content-type','application/json')
                     ->_display(json_encode($followup));
    }

}