<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Services 
 *
 * Report services on dashboard module
 * 
 * @author Oriza 
 * @package Dashboard
 */

class Services extends Backend_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->output->enable_profiler(false);
    }
    
    /**
     * Show learning logs.
     * 
     * @return object
     */
	public function logs()
	{
        $startDate = $this->input->get('startDate') ?? '2018-01-01';
        $endDate = $this->input->get('endDate') ?? '2020-12-31';

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="'. $startDate . '#' . $endDate . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $file = fopen('php://output', 'w');

        fputcsv($file, ['ID', 'Nama', 'Email', 'Kursus', 'Materi', 'Waktu Akses', 'Lama Belajar', 'Klik Sudah Paham', 'Waktu Klik Sudah Paham']);

        $this->db->select('mein_users.id, mein_users.name, mein_users.email, courses.course_title, accesslog.referer_url, accesslog.viewed, accesslog.learned, accesslog.created_at, accesslog.updated_at');
        $this->db->from('accesslog');
        $this->db->join('mein_users', 'mein_users.id = accesslog.user_id');
        $this->db->join('courses', 'courses.id = accesslog.object_id');
        $this->db->where('accesslog.created_at >=', $startDate);
        $this->db->where('accesslog.created_at <=', $endDate);
        $this->db->limit(1000);
        
        $results = $this->db->get()->result();

        foreach ($results as $result) {

            if ($result->updated_at == null) {
                $duration = 1;
            } else {
                $date1 = strtotime($result->updated_at);
                $date2 = strtotime($result->created_at);
                $diff = $date1 - $date2;
                $duration = ceil($diff / 60);
            }

            $lesson = explode('/', $result->referer_url);

            if ($result->learned > 0) {
                $learned = 'Ya';
            } else {
                $learned = 'Tidak';
            }

            if ($result->updated_at == null) {
                $learnedTime = $result->created_at;
            } else {
                $learnedTime = $result->updated_at;
            }

            fputcsv($file, [
                $result->id,
                $result->name, 
                $result->email, 
                $result->course_title, 
                $lesson[7], 
                $result->created_at, 
                $duration . ' menit',
                $learned,
                $learnedTime
            ]);
        }
    }

    /**
     * Show Intala.
     * 
     * @return object
     */
	public function report()
	{
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="'. $startDate . '#' . $endDate . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $file = fopen('php://output', 'w');
        
        // Total Transactions ..
        $this->db->from('payment_order');
        $this->db->where('transaction_status', 'settlement');
        
        $total['settlement'] = $this->db->get()->num_rows();
        
        $this->db->from('payment_order');
        $this->db->where('transaction_status', 'pending');
        
        $total['pending'] = $this->db->get()->num_rows();
        
        $this->db->select('sum(gross_amount_discount) as total');
        $this->db->from('payment_order');
        $this->db->where('transaction_status', 'settlement');
        
        $transaction = $this->db->get()->row();

        // Create statistics report ..
        fputcsv($file, [
            'Settlement: ' . $total['settlement'], 
            'Pending: ' . $total['pending'],
            'Transaction: Rp. ' . number_format($transaction->total) . ',-'
        ]);
        
        // Create data title
        fputcsv($file, ['Produk', 'Nama', 'Email', 'Hp', 'Tipe Bayar', 'Kode Kupon', 'Status', 'Jumlah', 'Tanggal']);
        
        // Get order data.
        $fields  = 'any_value(products.product_name) as product, ';
        $fields .= 'any_value(mein_users.name) as name, '; 
        $fields .= 'any_value(mein_users.email) as email, ';
        $fields .= 'any_value(mein_user_profile.phone) as phone, ';
        $fields .= 'any_value(payment_order.payment_type) as payment_type, ';
        $fields .= 'any_value(payment_order.coupon_code) as coupon_code, ';
        $fields .= 'any_value(payment_order.transaction_status) as transaction_status, ';
        $fields .= 'any_value(payment_order.gross_amount_discount) as gross_amount_discount, ';
        $fields .= 'any_value(payment_order.created_at) as created_at';

        $this->db->select($fields);
        $this->db->from('payment_order');
        $this->db->join('payment_order_items', 'payment_order_items.order_id = payment_order.id');
        $this->db->join('products', 'products.id = payment_order_items.product_id');
        $this->db->join('mein_users', 'mein_users.id = payment_order.user_id');
        $this->db->join('mein_user_profile', 'mein_user_profile.user_id = mein_users.id');
        $this->db->where('payment_order.created_at >=', $startDate);
        $this->db->where('payment_order.created_at <=', $endDate);
        $this->db->group_by('payment_order.id');
        
        $results = $this->db->get()->result();
        
        foreach($results as $result) 
        {
            fputcsv($file, [
                $result->product,
                $result->name, 
                $result->email, 
                $result->phone, 
                $result->payment_type, 
                $result->coupon_code, 
                $result->transaction_status,
                number_format($result->gross_amount_discount),
                $result->created_at
            ]);
        }
    }
}