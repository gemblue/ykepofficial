<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *	Global Shortcode
 *	
 *  Theme api for global shortcode
 */
class GlobalShortcode extends LexCallback {

	public function session()
	{
        
		$name = $this->getAttribute('name', 'message');
        
        return $this->session->userdata($name);
    }

    public function unset_session()
    {
        $name = $this->getAttribute('name', 'message');
        
        return $this->session->unset_userdata($name);
    }

    public function sess_destroy()
    {
        return $this->session->sess_destroy();
    }

    public function format_date()
    {
        $format = $this->getAttribute('format', 'd-m-Y');
        $time = $this->getAttribute('time', time());
        if(! is_int($time))
            $time = strtotime($time);

        return date($format, $time);
    }

    public function ucfirst()
    {
        $content = $this->getAttribute('content');
        
        return ucfirst($content);
    }

    public function number_format()
    {
        $number = $this->getAttribute('number', 0);
        $decimal = $this->getAttribute('decimal', 0);
        $thousand_sep = $this->getAttribute('thousand_sep', '.');
        $decimal_sep = $this->getAttribute('decimal_sep', ',');

        return number_format($number, $decimal, $decimal_sep, $thousand_sep);
    }

    public function get_segment()
    {
        $segment = $this->getAttribute('segment');

        return $ci->uri->segment($segment);
    }
}