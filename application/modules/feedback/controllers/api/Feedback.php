<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Feedback
 * 
 * Feedback API services.
 * 
 * @author Gemblue
 */

use App\modules\feedback\models\Feedback as FeedbackModel;

class Feedback extends REST_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Show all feedback
     */
	public function index()
	{
        $Feedback = new FeedbackModel;

        $result = $Feedback->gets();

        if ($result) {
            $this->response($result);
        }

        $this->response(['status' => 'failed', 'message' => 'There is no feedback'], 400);
    }


    /**
     * Get all feedback by course id
     */
	public function course($slug)
	{
        $Feedback = new FeedbackModel;

        $result = $Feedback->getsByCourseSlug($slug);

        if ($result) {
            $this->response($result);
        }

        $this->response(['status' => 'failed', 'message' => 'There is no feedback'], 400);
    }

    /**
     * Push new feedback
     */
	public function insert()
	{
        $this->user =  $this->checkToken();

        $input = file_get_contents("php://input");
        $post = json_decode($input, true);

        $Feedback = new FeedbackModel;

        if ($Feedback->send($this->user->user_id, $post)) {
            $this->response(['status' => 'success', 'message' => 'Feedback is successfully saved.']);
        }

        $this->response(['status' => 'failed', 'message' => 'There is a problem on create new feedback'], 400);
    }
}