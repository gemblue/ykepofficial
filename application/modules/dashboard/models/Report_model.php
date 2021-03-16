<?php

/**
 * Report
 *
 * @author Oriza
 */

class Report_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
    }
    
    public function getRecentLogin($hour_ago, $returnTotal = false, $limit = 10, $order = 0)
    {
        $hour_ago = date('Y-m-d H:i:s', strtotime('-' . $hour_ago . ' hour'));

        $this->db->select('*');
        $this->db->from('mein_users');
        $this->db->where('last_login >=', $hour_ago);
        
        if ($returnTotal) {
            return $this->db->get()->num_rows(); 
        }

        $this->db->order_by('last_login', 'desc');
        $this->db->limit($limit, $order);
        
        return $this->db->get()->result();
    }

    public function getTotalSelling($start, $end)
    {
        $this->db->select('payment_order.id');
        $this->db->from('payment_order');
        $this->db->where_in('transaction_status', ['settlement', 'process', 'shipped', 'done']);
        $this->db->where('payment_order.created_at >=', $start);
		$this->db->where('payment_order.created_at <=', $end);
        
        return $this->db->get()->num_rows();
    }

    public function getTotalTransaction($start, $end)
    {
        $this->db->select('sum(payment_order.gross_amount_discount) as total');
        $this->db->from('payment_order');
        $this->db->where_in('transaction_status', ['settlement', 'process', 'shipped', 'done']);
        $this->db->where('payment_order.created_at >=', $start);
		$this->db->where('payment_order.created_at <=', $end);
        
        $result = $this->db->get()->row();
        
        if (!empty($result))
            return $result->total;

        return null;
    }
}