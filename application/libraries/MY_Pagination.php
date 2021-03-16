<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/pagination.html
 */
class MY_Pagination extends CI_Pagination {

	public function create_next_link()
	{
		$query_string_array = $this->CI->input->get(null, true);
		$total_page = (int) ceil($this->total_rows / $this->per_page);
		
		$next_page = ($query_string_array['page'] ?? 1) + 1;
		if($next_page > $total_page) return null;

		$query_string_array['page'] = $next_page;
		$query_string = http_build_query($query_string_array);
		
		$next_url = site_url(trim($this->base_url).'?'.$query_string);
		return $next_url;
	}

	public function create_prev_link()
	{
		$query_string_array = $this->CI->input->get(null, true);
		
		$prev_page = ($query_string_array['page'] ?? 1) - 1;
		if($prev_page <= 0) return null;

		$query_string_array['page'] = $prev_page;
		$query_string = http_build_query($query_string_array);
		
		$prev_url = site_url(trim($this->base_url).'?'.$query_string);
		return $prev_url;
	}

}
