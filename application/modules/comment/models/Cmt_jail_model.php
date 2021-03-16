<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comment Jail
 *
 * @author Oriza
 */

class Cmt_jail_model extends MY_Model
{
	// Define table name
	public $table = 'comment_jail';
	public $users = 'mein_users';
    
	// Define field that must be protected (not insert or updated manually)
	public $protected = ['id'];
    
	// Define fields for form insert and update purpose
	// You can define validation rules here just like CodeIgniter has
	public $fields = [
        'user_id' => [
			'field'=>'user_id',
			'label'=>'User',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'failed' => [
			'field'=>'failed',
			'label'=>'Failed',
			'datalist' => true,
			'rules'=>'trim|required',
		],
        'jailed' => [
			'field'=>'jailed',
			'label'=>'Jailed',
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

    public function getJailedUsers($limit = null, $order = null, $returnTotal = false)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join($this->users, $this->users . '.id = ' . $this->table . '.user_id');
        
        if ($returnTotal)
            return $this->db->get()->num_rows();
        
        if ($limit != null)
            $this->db->limit($limit, $order);

        $this->db->order_by($this->table . '.created_at', 'desc');

        return $this->db->get()->result();
    }

    public function checkSpam($user_id, $table)
    {
        // Is jailed?
        $jailed = $this->isJailed($user_id);
        
        if ($jailed)
            return ['status' => 'failed', 'message' => 'Kamu tidak bisa berkomentar lagi, hubungi admin untuk memulihkan'];
        
        // Take one minutes ago
        $start = date('Y-m-d H:i:s', strtotime('-1 minutes'));
        $end = date('Y-m-d H:i:s', strtotime('+1 minutes'));
        
        // Get total message.
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('user_id', $user_id);
        $this->db->where('created_at >=', $start);
        $this->db->where('created_at <=', $end);
        
        $total = $this->db->get()->num_rows();

        if ($total > 5)
        {
            // Naikan failed attempt.
            $this->addFailed($user_id);

            return ['status' => 'failed', 'message' => 'Kamu terlalu banyak mengirim pesan dalam satu menit ini. Mohon hentikan kegiatan ini atau kami akan menonaktifkan fitur komentarmu.'];
        }

        return ['status' => 'success', 'message' => 'Ok'];
    }

    public function isJailed($user_id)
    {
        $jail = $this->where('user_id', $user_id)->get();

        if ($jail['jailed'])
            return true;
        
        return false;
    }

    public function addFailed($user_id)
    {
        // Is exist?
        $jail = $this->where('user_id', $user_id)->get();
        
        if (!$jail) 
        {
            $this->insert([
                'user_id' => $user_id,
                'failed' => 1,
                'jailed' => false
            ]);

            return true;
        }

        if ($jail['failed'] > 5)
        {
            // Set jailed become true.
            $this->db->where('user_id', $user_id)->update($this->table, ['jailed' => TRUE]);
            
            return true;
        }

        $this->db->where('user_id', $user_id)->set('failed', 'failed+1', FALSE);
        
        return $this->db->update($this->table);
    }

    public function setFree($jail_id)
    {
        $this->db->where('id', $jail_id);
        return $this->db->update($this->table, ['failed' => 0, 'jailed' => 0]);
    }

    public function jail($jail_id)
    {
        $this->db->where('id', $jail_id);
        return $this->db->update($this->table, ['jailed' => 1]);
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