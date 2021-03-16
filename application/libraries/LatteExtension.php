<?php

namespace App\libraries;

class LatteExtension
{
    private $latte;

    function __construct($latte)
    {
        $this->latte = $latte;

        ci()->load->config('twig');
    }

    public function getFilters()
    {
        $functions = [];
        foreach (ci()->config->config['twig_filters'] as $function) {
            $functions[] = new \Twig_Filter($function, $function);
        }

        $specials = [];

        return array_merge($functions, $specials);
    }

    public function setFunctions()
    {
        $functions = config_item('twig_functions');
        foreach ($functions as $func) {
            $this->latte->addFunction($func, function (...$args) use ($func) {
                return call_user_func_array($func, $args);
            });
        }

        $this->latte->addFunction('shortcode', function(...$args) {
            return call_user_func_array([$this, 'shortcode'], $args);
        });
        $this->latte->addFunction('library', function(...$args) {
            return call_user_func_array([$this, 'library'], $args);
        });
        $this->latte->addFunction('get', function(...$args) {
            return call_user_func_array([$this, 'catchGetVar'], $args);
        });
        $this->latte->addFunction('env', function(...$args) {
            return call_user_func_array([$this, 'catchEnvVar'], $args);
        });
    }

    function shortcode($shortcode, $args = [])
	{
		$ci =& get_instance();

    	if(!strpos($shortcode, '.'))
    		show_error('"'. $shortcode .'" as shortcode must contain dot "." as separator between module name and shortcode function name.');

    	list($module, $method) = explode('.', $shortcode);
        $className = ucfirst($module).'Shortcode';

        if(!isset(ci()->shortcodeClasses[$className]))
        {
            $modules =& $ci->config->config['modules'];
            
            // check shortcode from shortcode application folder first
            if(file_exists(APPPATH.'shortcodes/'.$className.'.php'))
            {
                if(!class_exists($className, false))
                    include_once APPPATH.'shortcodes/'.$className.'.php';

                ci()->shortcodeClasses[$className] = new $className();
            }

            // check shortcode from shared shortcodes folder
            else if(file_exists('shared/shortcodes/'.$className.'.php'))
            {
                if(!class_exists($className, false))
                    include_once 'shared/shortcodes/'.$className.'.php';

                ci()->shortcodeClasses[$className] = new $className();
            }

            // check shortcode from module if exist
            else if(isset($modules[$module])
                    && file_exists($modules[$module]['path'].'Shortcodes.php'))
            {
                if(!class_exists($className, false))
                    include_once $modules[$module]['path'].'Shortcodes.php';

                ci()->shortcodeClasses[$className] = new $className();
            } 

            else {
                show_error('"'. $shortcode .'" shortcode not found in any module.');
            }

            unset($modules);
        }

        ci()->shortcodeClasses[$className]->setAttributes($args);
    	return ci()->shortcodeClasses[$className]->$method();
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
