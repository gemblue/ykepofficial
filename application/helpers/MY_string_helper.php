<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('starts_with'))
{
	function starts_with($string, $substring)
	{
		if(strpos($string, $substring) === 0)
			return true;

		return false;
	}
}

