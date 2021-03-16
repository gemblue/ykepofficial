<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LexCallback extends TwigCallback {

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		return get_instance()->$key;
	}

}