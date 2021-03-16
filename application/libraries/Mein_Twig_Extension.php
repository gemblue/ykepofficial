<?php

namespace App\libraries;

class Mein_Twig_Extension extends \Twig_Extension
{
    private $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('twig');
    }

    public function getFilters()
    {
        $functions = [];
        foreach ($this->ci->config->config['twig_filters'] as $function) {
            $functions[] = new \Twig_Filter($function, $function);
        }

        $specials = [];

        return array_merge($functions, $specials);
    }

    public function getFunctions()
    {
        $functions = [];
        foreach ($this->ci->config->config['twig_functions'] as $function) {
            $functions[] = new \Twig_Function($function, $function);
        }

        $specials = [
            new \Twig_Function('s', [$this, 'shortcode']),
            new \Twig_Function('l', [$this, 'library']),
            new \Twig_Function('_get', [$this, 'catchGetVar']),
            new \Twig_Function('_env', [$this, 'catchEnvVar']),
        ];

        return array_merge($functions, $specials);
    }

    function shortcode($shortcode, $args = [])
	{
		$ci =& get_instance();

    	if(!strpos($shortcode, '.'))
    		show_error('"'. $shortcode .'" as shortcode must contain dot "." as separator between module name and shortcode function name.');

    	list($module, $method) = explode('.', $shortcode);
        $className = ucfirst($module).'Shortcode';

        if(!isset($this->ci->shortcodeClasses[$className]))
        {
            $modules =& $ci->config->config['modules'];
            
            // check shortcode from shortcode application folder first
            if(file_exists(APPPATH.'shortcodes/'.$className.'.php'))
            {
                if(!class_exists($className, false))
                    include_once APPPATH.'shortcodes/'.$className.'.php';

                $this->ci->shortcodeClasses[$className] = new $className();
            }

            // check shortcode from shared shortcodes folder
            else if(file_exists('shared/shortcodes/'.$className.'.php'))
            {
                if(!class_exists($className, false))
                    include_once 'shared/shortcodes/'.$className.'.php';

                $this->ci->shortcodeClasses[$className] = new $className();
            }

            // check shortcode from module if exist
            else if(isset($modules[$module])
                    && file_exists($modules[$module]['path'].'Shortcodes.php'))
            {
                if(!class_exists($className, false))
                    include_once $modules[$module]['path'].'Shortcodes.php';

                $this->ci->shortcodeClasses[$className] = new $className();
            } 

            else {
                show_error('"'. $shortcode .'" shortcode not found in any module.');
            }

            unset($modules);
        }

        $this->ci->shortcodeClasses[$className]->setAttributes($args);
    	return $this->ci->shortcodeClasses[$className]->$method();
    }

    function library($shortcode, $args = [])
    {
        $ci =& get_instance();

        if(!strpos($shortcode, '.'))
            show_error('"'. $shortcode .'" as shortcode must contain dot "." as separator between library name and method name.');

        list($library, $method) = explode('.', $shortcode);

        return call_user_func_array([$ci->$library, $method], $args);
    }

    function catchGetVar($key = null)
    {
        $ci =& get_instance();

        return $ci->input->get($key, true);
    }

    function catchEnvVar($key = null)
    {
        return $_ENV[$key] ?? null;
    }


}
