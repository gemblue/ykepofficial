<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Services 
 *
 * @author Oriza 
 * @package Product
 */

class Services extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->output->enable_profiler(false);
    }
    
    /**
     * Reset Discount Cookies
     * 
     * @return mixed
     */
	public function resetDiscountCookie()
	{
        $this->load->helper('cookie');
        delete_cookie('DiscountDate');
        
        echo 'Done!';
    }
}