<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Repository Class
 *
 * adapted from CI_Model
 *
 * @package		MeinCMS
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Toni Haryanto
 */
class Repository {

	public function __construct() {}

	/**
	 * __get magic
	 *
	 * Allows repositories to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your repository code.
		return get_instance()->$key;
	}

}
