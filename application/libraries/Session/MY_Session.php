<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session {


	/**
	 * Set userdata
	 *
	 * Legacy CI_Session compatibility method
	 *
	 * @param	mixed	$data	Session data key or an associative array
	 * @param	mixed	$value	Value to store
	 * @return	void
	 */
	public function set_userdata($data, $value = NULL, $group = false)
	{
		if (is_array($data))
		{
			foreach ($data as $key => &$value)
			{
				if($group)
					$_SESSION[$group][$key] = $value;
				else
					$_SESSION[$key] = $value;

			}

			return;
		}

		if($group)
			$_SESSION[$group][$data] = $value;
		else
			$_SESSION[$data] = $value;
	}

	/**
	 * Set flashdata
	 *
	 * Legacy CI_Session compatibility method
	 *
	 * @param	mixed	$data	Session data key or an associative array
	 * @param	mixed	$value	Value to store
	 * @return	void
	 */
	public function set_flashdata($data, $value = NULL)
	{
		$this->set_userdata($data, $value, '__flash');
		$this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
	}

	/**
	 * Mark as flash
	 *
	 * @param	mixed	$key	Session data key(s)
	 * @return	bool
	 */
	public function mark_as_flash($key)
	{
		if (is_array($key))
		{
			for ($i = 0, $c = count($key); $i < $c; $i++)
			{
				// Don't move from root session if it already exist
				if(isset($_SESSION['__flash'][$key[$i]])) continue;

				// move session to flash
				if (isset($_SESSION[$key[$i]]))
				{
					$_SESSION['__flash'][$key[$i]] = $_SESSION[$key[$i]];
					unset($_SESSION[$key[$i]]);
				}

			}

			$new = array_fill_keys($key, 'new');

			$_SESSION['__ci_vars'] = isset($_SESSION['__ci_vars'])
				? array_merge($_SESSION['__ci_vars'], $new)
				: $new;

			return TRUE;
		}

		// Don't move from root session if it already exist
		if( ! isset($_SESSION['__flash'][$key]))
		{
			if ( ! isset($_SESSION[$key])) return FALSE;

			// move session to flash
			$_SESSION['__flash'][$key] = $_SESSION[$key];
			unset($_SESSION[$key]);
		}

		$_SESSION['__ci_vars'][$key] = 'new';
		return TRUE;
	}

	/**
	 * Flashdata (fetch)
	 *
	 * Legacy CI_Session compatibility method
	 *
	 * @param	string	$key	Session data key
	 * @return	mixed	Session data value or NULL if not found
	 */
	public function flashdata($key = NULL)
	{
		if (isset($key))
		{
			return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION['__flash'][$key]) && ! is_int($_SESSION['__ci_vars'][$key]))
				? $_SESSION['__flash'][$key]
				: NULL;
		}

		$flashdata = array();

		if ( ! empty($_SESSION['__ci_vars']))
		{
			foreach ($_SESSION['__ci_vars'] as $key => &$value)
			{
				is_int($value) OR $flashdata[$key] = $_SESSION['__flash'][$key];
			}
		}

		return $flashdata;
	}

	/**
	 * Handle temporary variables
	 *
	 * Clears old "flash" data, marks the new one for deletion and handles
	 * "temp" data deletion.
	 *
	 * @return	void
	 */
	protected function _ci_init_vars()
	{
		if ( ! empty($_SESSION['__ci_vars']))
		{
			$current_time = time();

			foreach ($_SESSION['__ci_vars'] as $key => &$value)
			{
				if ($value === 'new')
				{
					$_SESSION['__ci_vars'][$key] = 'old';
				}
				// Hacky, but 'old' will (implicitly) always be less than time() ;)
				// DO NOT move this above the 'new' check!
				elseif ($value < $current_time)
				{
					if(is_int($value))
						unset($_SESSION[$key], $_SESSION['__ci_vars'][$key]);
					else
						unset($_SESSION['__flash'][$key], $_SESSION['__ci_vars'][$key]);
				}
			}

			if (empty($_SESSION['__ci_vars']))
			{
				unset($_SESSION['__ci_vars']);
			}
		}

		$this->userdata =& $_SESSION;
	}

}