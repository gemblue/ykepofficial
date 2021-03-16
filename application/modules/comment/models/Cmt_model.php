<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comment
 *
 * @author Oriza
 */

class Cmt_model extends MY_Model
{
	// Define table name
	public $table = 'comment';
    
	// Define field that must be protected (not insert or updated manually)
	public $protected = ['id'];

    public $soft_deletes = TRUE;
    
	// Define fields for form insert and update purpose
	// You can define validation rules here just like CodeIgniter has
	public $fields = [
        'reply_id' => [
			'field'=>'reply_id',
			'label'=>'Reply ID',
            'datalist' => false,
            'rules'=>'trim|required',
		],
        'user_id' => [
			'field'=>'user_id',
			'label'=>'User',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'comment_content' => [
			'field'=>'comment_content',
			'label'=>'Comment',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'comment_status' => [
			'field'=>'comment_status',
			'label'=>'Status',
			'datalist' => true,
			'rules'=>'trim|required',
		]
	];

	// Constructor
	public function __construct()
	{
        parent::__construct();

        $this->has_one['user'] = array('User_model', 'id', 'user_id');
    }

    /**
     * Get Comments ..
     * 
     * @return object
     */
    public function getComments($reply_id, $status = 'publish')
    {
       return $this->with_user()
                   ->where(['reply_id' => $reply_id, 'comment_status' => $status])
                   ->get_all();
    }

    /**
     * Update ..
     * 
     * @return object
     */
    public function updateComment($param)
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
