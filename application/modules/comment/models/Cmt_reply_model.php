<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comment Reply
 *
 * @author Oriza
 */

class Cmt_reply_model extends MY_Model
{
	// Define table name
	public $table = 'comment_reply';
    
	// Define field that must be protected (not insert or updated manually)
    public $protected = ['id'];
    
    public $soft_deletes = TRUE;
    
	// Define fields for form insert and update purpose
	// You can define validation rules here just like CodeIgniter has
	public $fields = [
        'identity' => [
			'field'=>'identity',
			'label'=>'Identity',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'user_id' => [
			'field'=>'user_id',
			'label'=>'User',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'reply_content' => [
			'field'=>'reply_content',
			'label'=>'Reply Content',
			'datalist' => true,
			'rules'=>'trim|required',
		],
		'reply_status' => [
			'field'=>'reply_status',
			'label'=>'Status',
			'datalist' => true,
			'rules'=>'trim|required',
		],
		'reply_mark' => [
			'field'=>'reply_mark',
			'label'=>'Mark',
			'datalist' => true
		]
	];

	// Constructor
	public function __construct()
	{
        parent::__construct();
        
        $this->has_one['user'] = array('User_model', 'id', 'user_id');
    }

    /**
	 * Get Total Reply by Thread.
	 *
     * @return int
	 */
	public function getTotal($thread_id)
	{
        return $this->where('thread_id', $thread_id)->count_rows();
    }

    /**
     * Update ..
     * 
     * @return object
     */
    public function updateReply($param)
    {
        $param['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->update($this->table, $param, ['id' => $param['id']]);
    }

	/**
     * Set filter using like statement
	 *
     * @param array $filter
     * @return array
	 */
    public function setFilter()
	{
        if($filter = $this->input->get('filter', true))
        $this->like($filter);
        
		return $this;
    }
}
