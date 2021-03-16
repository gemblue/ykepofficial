<?php namespace App\hooks;

/**
 * Define PreSystem hooks in one class
 * 
 * Just add new method and register its name in $methods property.
 * 
 * @package PreSystem
 * @author Toni
 */
class PreSystemHook extends BaseHook {

	protected $methods = [
		'registerWhoops'
	];

	/**
	 * Register Whoops class for error reporting
	 * 
	 * @package Whoops
	 * @author Toni
	 */
	public function registerWhoops()
	{
		if(ENVIRONMENT != 'production' && !is_cli()){
			$whoops = new \Whoops\Run;
			$handler = new \Whoops\Handler\PrettyPageHandler;
			
			$CFG =& load_class('Config', 'core');
			
			// Register blacklist if set
			if($CFG->item('whoops_blacklist'))
			{
				foreach ($CFG->item('whoops_blacklist') as $globalVar => $values)
					foreach ($values as $value)
						$handler->blacklist($globalVar, $value);
			}

			$whoops->pushHandler($handler);
			$whoops->register();
		}
	}
}