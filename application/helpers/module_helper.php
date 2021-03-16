<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

// Modules helpers, you can move this functions to a true helper file

/**
 * Return the CodeIgniter modules list
 * @param bool $with_location
 * @return array
 */
if (!function_exists('modules_list')) 
{
    function modules_list($with_location = TRUE)
    {
        // Get from config if already defined
        if(ci()->config->item('modules'))
            return ci()->config->item('modules');

        !function_exists('directory_map') && ci()->load->helper('directory');

        // Get disabled modules
        $disabled = [];
        if(file_exists(SITEPATH.'configs/disabled_modules.json'))
            $disabled = json_decode(file_get_contents(SITEPATH.'configs/disabled_modules.json'), true);

        $modules = array();

        // Reverse module location order so core module can override user module in menu 
        $module_locations = array_reverse(Modules::$locations);

        // Scan modules
        foreach ($module_locations as $location => $offset) 
        {
            $folders = directory_map($location, 1);

            // Skip if module folder empty
            if (! is_array($folders)) continue;

            // Get module list
            foreach ($folders as $folder)
            {
                if (is_dir($location . $folder) && file_exists($location . $folder . 'module.yml'))
                {
                	// Get simple module list
                	if(! $with_location)
                    	$modules[] = trim($folder,DIRECTORY_SEPARATOR);
                		
                    else {
                    	$modules[trim($folder,DIRECTORY_SEPARATOR)] = [
                    		0 => $location,
                    		1 => trim($folder,DIRECTORY_SEPARATOR),
                    		'path' => $location.$folder,
                            'enable' => ! in_array(trim($folder,DIRECTORY_SEPARATOR), $disabled)
                    	];

                    	// get module.yml
                        $parsed = [];
                    	if(file_exists($location.$folder.'module.yml')){
					        $parsed = Yaml::parseFile($location.$folder.'module.yml');
    	    				
                        }

                        // Set default module details
                        $default = [
                            "name" => ucfirst(trim($folder,DIRECTORY_SEPARATOR)),
                            "icon" => "file-o",
                            "description" => "",
                            "author" => "unknown",
                            "author_url" => "" ,
                            "custom_url" => "",
                            "show_admin_menu" => false,
                            "menu_position" => 90,
                            "parent_menu" => "",
                            "custom_menu" => "",
                            "setting" => false
                        ];
                        
                        $modules[trim($folder,DIRECTORY_SEPARATOR)] = array_merge($modules[trim($folder,DIRECTORY_SEPARATOR)], $default, $parsed);
                    }
                }

                // Get widgets
                if(file_exists($location . $folder . 'widgets/'))
                {
                    $modules[trim($folder,DIRECTORY_SEPARATOR)]['widgets'] = array_map(function($var) use ($folder){
                            if(substr($var, -1) == DIRECTORY_SEPARATOR)
                                return rtrim(rtrim($folder, '/').':'.$var, DIRECTORY_SEPARATOR);
                        }, directory_map($location . $folder . 'widgets/', 1));
                } 
            }
        }

        return $modules;
    }
}

/**
 * Check if a CodeIgniter module with the given name exists
 * @param $module_name
 * @return bool
 */
if (!function_exists('module_exists'))
{
    function module_exists($module_name)
    {
        return in_array($module_name, modules_list(FALSE));
    }
}

/**
 * Get module setting value
 * @param $module_name
 * @return bool
 */
if (!function_exists('setting_item'))
{
    function setting_item($setting_name)
    {
        list($module, $setting_key) = explode('.', $setting_name, 2);
        $module_settings = array_values(ci()->config->config['modules'][$module]['setting'] ?? []);

        $key = array_search($setting_key, array_column($module_settings, 'field'));
        if($key !== false)
            $setting_value = ci()->shared['settings'][$setting_name] ?? $module_settings[$key]['default'] ?? null;
        else
            $setting_value = ci()->shared['settings'][$setting_name] ?? null;

        return $setting_value;
    }
}

/**
 * Get module setting value
 * @param $module_name
 * @return bool
 */
if (!function_exists('setting_items'))
{
    function setting_items($module)
    {
        $settings_key = array_keys(ci()->shared['settings']);
        $m_array = preg_grep('/^'.$module.'\..*/', $settings_key);
        $result = [];
        foreach ($m_array as $key) {
            $result[substr($key, strlen($module)+1)] = ci()->shared['settings'][$key];
        }
        
        return $result;
    }
}


/**
 * Get setting item from module list YAML
 * @return array
 */
if (!function_exists('module_setting')) 
{
    function module_setting()
    {
        $modules = get_instance()->config->config['modules'];
        
        // Eliminate module without setting
        foreach($modules as $module => $module_value)
        {
            if(empty($modules[$module]['setting']) || !isPermitted('settings', $module))
                unset($modules[$module]);
        }
        
        return $modules;
    }
}

/**
 * Get setting item from module list YAML
 * @return array
 */
if (!function_exists('entry_setting')) 
{
    function entry_setting()
    {
        $modules = get_instance()->config->config['entries'];
        
        // Eliminate module without setting
        foreach($modules as $module => $module_value)
        {
            if(empty($modules[$module]['setting']) || !isPermitted('settings', $module))
                unset($modules[$module]);
        }
        
        return $modules;
    }
}

/**
 * Get setting item from module list YAML
 * @return array
 */
if (!function_exists('site_setting')) 
{
    function site_setting()
    {
        $settingFolder = SITEPATH.'settings/';

        $files = directory_map($settingFolder, 1);
        $settings = [];
        foreach ($files as $file) {
            $fileinfo = pathinfo($file);
            $settings[$fileinfo['filename']] = Yaml::parseFile($settingFolder.$file);
        }

        return $settings;
    }
}

/**
 * Get setting item from module list YAML
 * @return array
 */
if (!function_exists('plugin_setting')) 
{
    function plugin_setting()
    {
        $plugins = ci()->config->config['plugins'];
        
        // Eliminate module without setting
        foreach($plugins as $module => $module_value)
        {
            if(empty($plugins[$module]['setting']) || !isPermitted('settings', $module))
                unset($plugins[$module]);
        }
        
        return $plugins;
    }
}



if (!function_exists('normalizePath')) {

	/**
	 * Remove the ".." from the middle of a path string
	 * @param string $path
	 * @return string
	 */
	function normalizePath($path)
	{
		$parts    = array(); // Array to build a new path from the good parts
		$path     = str_replace('\\', '/', $path); // Replace backslashes with forwardslashes
		$path     = preg_replace('/\/+/', '/', $path); // Combine multiple slashes into a single slash
		$segments = explode('/', $path); // Collect path segments
		foreach ($segments as $segment) {
			if ($segment != '.') {
				$test = array_pop($parts);
				if (is_null($test))
					$parts[] = $segment;
				else if ($segment == '..') {
					if ($test == '..')
						$parts[] = $test;

					if ($test == '..' || $test == '')
						$parts[] = $segment;
				} else {
					$parts[] = $test;
					$parts[] = $segment;
				}
			}
		}

		return implode('/', $parts);
	}

}

if (!function_exists('isPermitted')) {
    
    function isPermitted($permission, $module, $whitelist = [])
    {
        return ci()->ci_auth->isPermitted($permission, $module, $whitelist);
    }
}
