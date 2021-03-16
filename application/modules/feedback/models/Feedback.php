<?php 

namespace App\modules\feedback\models; 

/**
 * Feedback
 * 
 * Feedback model
 *
 * @author Oriza
 */

class Feedback extends \CI_Model
{
	public function __construct()
	{
        parent::__construct();
    }

    public function gets() 
    {
        $this->db->select('feedback.rate, feedback.comment, courses.course_title, mein_users.id as user_id, mein_users.name, mein_users.email');
        $this->db->from('feedback');
        $this->db->join('mein_users', 'mein_users.id = feedback.user_id');
        $this->db->join('courses', 'courses.id = feedback.object_id');
        $this->db->order_by('feedback.id', 'desc');
        
        $result = $this->db->get()->result();

        return $result;
    }

    public function getsByCourseSlug($slug) 
    {
        $this->db->select('feedback.rate, feedback.comment, courses.course_title, mein_users.id as user_id, mein_users.name, mein_users.email');
        $this->db->from('feedback');
        $this->db->join('mein_users', 'mein_users.id = feedback.user_id');
        $this->db->join('courses', 'courses.id = feedback.object_id');
        $this->db->where('courses.slug', $slug);
        $this->db->where('object_type', 'course');
        $this->db->order_by('feedback.id', 'desc');

        $result = $this->db->get()->result();

        if ($result) {
            return $result;
        }
        
        return null;
    }

    public function send($userId, $arg) 
    {
        $result = $this->db->insert('feedback', [
            'user_id' => $userId,
            'rate' => $arg['rate'],
            'comment' => $arg['comment'],
            'object_id' => $arg['object_id'],
            'object_type' => $arg['object_type'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $result;
    }
}
