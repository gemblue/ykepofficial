<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Global Helper 
 */

if ( ! function_exists('_e'))
{
	// Echo variable with xss_clean first
	// Always use this function if you want to echo for save output
    function _e($variable, $disable = false)
    {
    	if(empty(trim($variable))) return;
    	
    	if($disable == true)
    		echo $variable;
    	else
	        echo xss_clean($variable);
    }
}

if ( ! function_exists('json_response'))
{
    function json_response($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;  
    }
}

if ( ! function_exists('firstParagraph'))
{
	function firstParagraph($str) 
	{
		return strip_tags(substr($str, 0, strpos($str, "\n")));
	}
}

if ( ! function_exists('get_excerpt'))
{
	function get_excerpt($str, $startPos=0, $maxLength=100) 
	{
		if(strlen($str) > $maxLength) {
			$excerpt   = substr($str, $startPos, $maxLength-3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt   = substr($excerpt, 0, $lastSpace);
			$excerpt  .= ' ...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}
}

if ( ! function_exists('make_label'))
{
	function make_label($string) 
	{
		$string = str_replace('-',' ', $string);
		$string = ucwords(str_replace('_',' ', $string));
		return $string;
	}
}

if ( ! function_exists('time_ago'))
{
	function time_ago($date)
	{
		$now = time();
		$seconds = strtotime($date);
		$selisih = $now - $seconds;

		// kalo lebih dari 7 hari yang lalu
		if(date('d', $selisih) > 7)
			return 'pada tanggal '.strftime("%e %B %Y", $seconds);
		else
			return strtolower(timespan($seconds, $now, 1)).' yang lalu';
	}
}

if ( ! function_exists('slugify'))
{
	function slugify($text){

		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
			return 'n-a';
		}

		return $text;
	}
}

if ( ! function_exists('site_config'))
{
	function site_config($item)
	{
		return ci()->config->config[$item];
	}
}

if(! function_exists('view')){
	function view($view, $data = [])
	{
		return ci()->load->view($view, $data, true);
	}
}

if(! function_exists('session')){
	function session($key)
	{
		return ci()->session->userdata($key);
	}
}

if(! function_exists('cache')){
	function cache()
	{
		if(! isset(ci()->tinyCache)){
			$cacheFactory = new Gemblue\TinyCache\CacheFactory;
	        $cacheConfig = config_item('cache_config');
	        $cacheDriver = $_ENV['CACHE_DRIVER'] ?? 'File';
	        ci()->tinyCache = $cacheFactory->getInstance($cacheDriver, $cacheConfig[$cacheDriver]);
		}
        
        return ci()->tinyCache;
	}
}

if(! function_exists('catchGetVar')){
	function catchGetVar($key = null)
	{
		return ci()->input->get($key, true);
	}
}

if(! function_exists('catchServerVar')){
	function catchServerVar($key = null)
	{
		return $_ENV[$key] ?? null;
	}
}

if(! function_exists('flashdata')){
	function flashdata($key)
	{
		return ci()->session->flashdata($key);
	}
}
if(! function_exists('set_flashdata')){
	function set_flashdata($key, $message)
	{
		return ci()->session->set_flashdata($key, $message);
	}
}

if(! function_exists('parsedown')){
	function parsedown($content)
	{
		$Parsedown = new ParsedownExtra();
		return $Parsedown->text(html_entity_decode($content));
	}
}

if(! function_exists('sum_times')){
	function sum_times($times) {
	    $seconds = 0;

	    foreach ($times as $time) {
	    	if(strpos($time, ':') === false) continue;
	        sscanf($time, "%d:%d", $minute, $second);
			$seconds += $minute * 60 + $second;
	    }

	    $minutes = floor($seconds / 60);
	    $result['hours'] = floor($minutes / 60);
	    $result['minutes'] = $minutes % 60;
	    
	    return $result;
	}
}

if(! function_exists('print_code')){
	function print_code(array $data) {
	    App\libraries\Console::log($data);
	}
}

if(! function_exists('gravatar')){
	function gravatar($email, $size = 80){
		$url = "https://www.gravatar.com/avatar/{md5($email)}?s=$size&default=mm";
		return $url;
	}
}

if(! function_exists('compare_with_symbol')){
	function compare_with_symbol($a, $b, $char) {
	    switch($char) {
	        case '==': return $a == $b;
	        case '!=': return $a != $b;
	        case '>': return $a > $b;
	        case '>=': return $a >= $b;
	        case '<': return $a < $b;
	        case '<=': return $a <= $b;
	        case '===': return $a === $b;
	        case '!==': return $a !== $b;
	    }
    }
}
