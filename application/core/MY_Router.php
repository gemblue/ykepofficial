<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* Load the MX_Router class */
require APPPATH . "third_party/MX/Router.php";

class MY_Router extends MX_Router {

	/** Locate the controller **/
	public function locate($segments)
	{
		$this->located = 0;
		$ext = $this->config->item('controller_suffix').EXT;

		/* Use module route if available */
		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;
		}

		/* Get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* Check modules */
		foreach (Modules::$locations as $location => $offset)
		{
			/* Module Exists? */
			if (is_dir($source = $location.$module.'/controllers/') 
				&& $this->__isModuleEnable($module)) // Show only enable module
			{
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';

				/* Module sub-controller exists? */
				if($directory)
				{
					/* Module sub-directory exists? */
					if(is_dir($source.$directory.'/'))
					{	
						$source .= $directory.'/';
						$this->directory .= $directory.'/';

						/* Module sub-directory controller exists? */
						if($controller)
						{
							if(is_file($source.ucfirst($controller).$ext))
							{
								$this->located = 3;
								return array_slice($segments, 2);
							}
							else $this->located = -1;
						}
					}
					else
					if(is_file($source.ucfirst($directory).$ext))
					{
						$this->located = 2;
						return array_slice($segments, 1);
					}
					else $this->located = -1;
				}

				/* Module controller exists? */
				if(is_file($source.ucfirst($module).$ext))
				{
					$this->located = 1;
					return $segments;
				}
			}
		}

		if( ! empty($this->directory)) return;

		/* Application sub-directory controller exists? */
		if($directory)
		{
			if(is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext))
			{
				$this->directory = $module.'/';
				return array_slice($segments, 1);
			}

			/* Application sub-sub-directory controller exists? */
			if($controller)
			{ 
				if(is_file(APPPATH.'controllers/'.$module.'/'.$directory.'/'.ucfirst($controller).$ext))
				{
					$this->directory = $module.'/'.$directory.'/';
					return array_slice($segments, 2);
				}
			}
		}

		/* Application controllers sub-directory exists? */
		if (is_dir(APPPATH.'controllers/'.$module.'/'))
		{
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}

		/* Application controller exists? */
		if (is_file(APPPATH.'controllers/'.ucfirst($module).$ext))
		{
			return $segments;
		}
		
		$this->located = -1;
	}

	private function __isModuleEnable($module)
	{
		if(file_exists(SITEPATH.'configs/disabled_modules.json')){
			$modules = json_decode(file_get_contents(SITEPATH.'configs/disabled_modules.json'), true);
			if(in_array($module, $modules)){
				if($_ENV['CI_ENV'] != 'production')
					show_error("Module $module is disabled. Check in site configs.");
				return false;
			}
		}
		return true;
	}
}