<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

use App\libraries\LatteFileLoader;

class MY_Loader extends MX_Loader {

    private $parser;
    private $parse_content = true;
    private $callbacks = [];

    protected $_ci_repositories = [];

    protected $_ci_events_paths = array();

    public function __construct()
    {
        parent::__construct();

        $this->parser = new Lex\Parser();
    }

    public function parseContent($parse = true)
    {
        $this->parse_content = $parse;
        return $this;
    }

    // Load a module view
    public function view($view, $vars = array(), $return = FALSE)
    {
        list($path, $_view) = Modules::find($view, $this->_module, 'views/');

        $vars = array_merge($this->shared, $vars);

        if ($path != FALSE)
        {
            $this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
            $view = $_view;
        }

        // add theme path to view paths
        $this->_ci_view_paths = [realpath(VIEW_FOLDER).DIRECTORY_SEPARATOR => TRUE] 
                                + $this->_ci_view_paths;

        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
    }

    // View with parsing
    public function view_parse($view, $data = array(), $return = FALSE) 
    {        
        $content = $this->view($view, $data, true);

        if($this->parse_content)
            $content = $this->view_parse_content($content, $data);

        if($return)
            return $content;

        echo $content;
    }

    // Parse content
    public function view_parse_content($content, $data = array()) 
    {
        return $this->parser->parse($content, $data, array($this, '_lexCallback'), true);
    }

    public function view_partial($view, $data = [], $return = false, $parse = false)
    {
        // merge and override shared data
        $data = array_merge($this->shared, $data);

        // Override theme name if set
        // if($theme) $data['theme'] = $theme;

        $content = $this->view($data['theme'].'/partials/'.$view, $data, true);

        // if($parse)
        //     $content = $this->view_parse_content($content, $data);

        if($return)
            return $content;

        echo $content;
    }

    public function view_block($view, $data = [], $return = false)
    {
        // merge and override shared data
        $data = array_merge($this->shared, $data);

        if(!file_exists($data['theme_path'].'/blocks/'.$view.'.php')) return false;

        $content = $this->view($data['theme'].'/blocks/'.$view, $data, true);
     
        if($return)
            return $content;

        echo $content;
    }

    public function view_page($page, $data = [], $return = false)
    {
        // merge and override shared data
        $data = array_merge($this->shared, $data);

        if(!file_exists($data['theme_path'].'/pages/'.$page.'/content.html')) return false;

        $content = $this->view($data['theme'].'/pages/'.$page.'/content.html', $data, true);
     
        if($return)
            return $content;

        echo $content;
    }

    public function view_layout($view, $data = [], $return = false, $theme = null)
    {
        // Parse shared data in partial
        $data = array_merge($this->shared, $data);

        $title_separator = $this->config->config['title_separator'] ?? '-';

        // Set Site title tag
        if(isset($data['page_title']))
            $data['title'] = $data['page_title'] . " $title_separator ". ($data['site_title'] ?? '');
        else
            $data['title'] = $data['site_title'];

        // Override theme name if set
        if($theme) $data['theme'] = $theme;

        // Render Layout
        $content = $this->view_parse($data['theme'].'/layouts/'.$view, $data, true);

        if($return)
            return $content;

        echo $content;
    }

    public function _lexCallback($parsename, $attributes, $content)
    {
        $return = null;
        $shortcode = explode(".", $parsename);

        // Get shortcode name and subname, 
        // I.e. common.date, 'common' is shortcode name and date is subname
        if(count($shortcode) >= 2)
        {
            // Separate module, name and subname
            if(count($shortcode) > 2)
            {
                list($module, $name, $subname) = $shortcode;

            } else {
                // if only has 2 segment, means name and module are same
                list($name, $subname) = $shortcode;
                $module = $name;
            }

            // Load shortcode class first
            $classAlias = ucfirst($module).ucfirst($name).'Shortcode';
            $className = ucfirst($name).'Shortcode';

            if(!isset($this->callbacks[$classAlias]))
            {
                $modules = $this->config->config['modules'];

                // check shortcode from shortcode application folder first
                if(file_exists(APPPATH.'shortcodes/'.$className.'.php'))
                {
                    if(!class_exists($className, false))
                        include_once APPPATH.'shortcodes/'.$className.'.php';
    
                    $this->callbacks[$classAlias] = new $className();
                }

                // check shortcode from shared shortcodes folder
                else if(file_exists('shared/shortcodes/'.$className.'.php'))
                {
                    if(!class_exists($className, false))
                        include_once 'shared/shortcodes/'.$className.'.php';
    
                    $this->callbacks[$classAlias] = new $className();
                }

                // check shortcode from module if exist
                else if(isset($modules[$module])
                        && file_exists($modules[$module]['path'].'Shortcodes.php'))
                {
                    if(!class_exists($className, false))
                        include_once $modules[$module]['path'].'Shortcodes.php';
    
                    $this->callbacks[$classAlias] = new $className();
                }

                unset($modules);
            }

            // Now run callback if shortcode instance already exist
            if(isset($this->callbacks[$classAlias]))
            {
                $this->callbacks[$classAlias]->setAttributes($attributes);
                $data = $this->callbacks[$classAlias]->{$subname}();

                if(is_array($data))
                {
                    $return = $this->parser->parse($content, $data, array($this, '_lexCallback'));
                }
                else
                    $return = $data;
            }
        }
        
        // If shortcode not exist as data, 
        // Probably it is php function
        else if(function_exists($parsename)) {
            return call_user_func_array($parsename, $attributes);
        }


        return $return;
    }

    function render($view, $data = [], $return = false)
    {
        // Use .php if $view doesn't have extension
        $viewinfo = pathinfo($view);
        if(!isset($viewinfo['extension'])) $view .= '.html';
        
        $latte = new Latte\Engine;
        $latte->setTempDirectory('../src/resources/cache/latte');

        // Define functions and filters
        $latteExt = new \App\libraries\LatteExtension($latte);
        $latteExt->setFunctions();

        // Prepare default page data
        $data = $this->_preparePagedata($data);

        // Set default layout path
        $latte->setLoader(new LatteFileLoader($this->_module));

        $final = $latte->renderToString($view, $data);
        
        if($_ENV['MINIFY_HTML'] ?? null)
            $final = minifyHTML($final);
        
        if($return)
            return $final;
        
        echo $final;
    }

    private function _preparePagedata($data)
    {
        $ci =& get_instance();
        
        $data = array_merge($data, $ci->shared);

        // Set default meta title and description
        if(!isset($data['page_title']) || empty($data['page_title']))
            $data['page_title'] = site_config('current_modules')['name'] ?? site_config('current_modules');

        if(!isset($data['meta_description']) || empty($data['meta_description']))
            $data['meta_description'] = site_config('current_modules')['description'] ?? '';

        $title_separator = $ci->config->config['title_separator'] ?? '-';

        // Set Site title tag
        if(isset($data['page_title']))
            $data['title'] = $data['page_title'] . " $title_separator ". $data['site_title'];
        else
            $data['title'] = $data['site_title'];

        return $data;
    }

    // Override model() method from MX_Loader
    // just to change use of load_class to $this->load_class_without_instantiate
    public function model($model, $object_name = NULL, $connect = FALSE, $params = [])
    {
        if (is_array($model)) return $this->models($model);

        ($_alias = $object_name) OR $_alias = basename($model);

        if (in_array($_alias, $this->_ci_models, TRUE))
            return $this;

        /* check module */
        list($path, $_model) = Modules::find($model, $this->_module, 'models/');

        if ($path == FALSE)
        {
            /* check application & packages */
            parent::model($model, $object_name, $connect);
        }
        else
        {
            class_exists('CI_Model', FALSE) OR $this->load_class_without_instantiate('Model', 'core');

            if ($connect !== FALSE && ! class_exists('CI_DB', FALSE))
            {
                if ($connect === TRUE) $connect = '';
                $this->database($connect, FALSE, TRUE);
            }

            Modules::load_file($_model, $path);

            $model = ucfirst($_model);
            CI::$APP->$_alias = new $model($params);

            $this->_ci_models[] = $_alias;
        }
        return $this;
    }

    public function registerModel($modelName, $object)
    {
        if(! in_array($modelName, $this->_ci_models)) {
            CI::$APP->$modelName = $object;
            $this->_ci_models[] = $modelName;
        }
    }

    // Override model() method from MX_Loader
    // just to change use of load_class to $this->load_class_without_instantiate
    public function repository($repository, $params = NULL)
    {
        $_alias = basename($repository);

        if (in_array($_alias, $this->_ci_repositories, TRUE))
            return $this;

        /* check module */
        list($path, $_repository) = Modules::find($repository, $this->_module, 'repositories/');

        // We only use repository inside module
        if ($path !== FALSE)
        {
            class_exists('Repository', FALSE) OR require_once(APPPATH.'libraries/Repository.php');

            Modules::load_file($_repository, $path);

            $repository = ucfirst($_repository);
            CI::$APP->$_alias = new $repository();

            $this->_ci_repositories[] = $_alias;
        }
        return $this;
    }

    // This used to load MY_Model which is no need 
    // and must not instantiate jus like load_class does 
    function load_class_without_instantiate($class, $directory = 'libraries')
    {
        if ( ! class_exists('CI_Model', FALSE))
        {
            $app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
            if (file_exists($app_path.'Model.php'))
            {
                require_once($app_path.'Model.php');
                if ( ! class_exists('CI_Model', FALSE))
                {
                    throw new RuntimeException($app_path."Model.php exists, but doesn't declare class CI_Model");
                }

                log_message('info', 'CI_Model class loaded');
            }
            elseif ( ! class_exists('CI_Model', FALSE))
            {
                require_once(BASEPATH.'core'.DIRECTORY_SEPARATOR.'Model.php');
            }

            $class = config_item('subclass_prefix').'Model';
            if (file_exists($app_path.$class.'.php'))
            {
                require_once($app_path.$class.'.php');
                if ( ! class_exists($class, FALSE))
                {
                    throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
                }

                log_message('info', config_item('subclass_prefix').'Model class loaded');
            }
        }
    }

    public function currentModule()
    {
        return $this->_module;
    }

    /**
     * Load Events
     *
     * This function loads the requested class.
     *
     * @param   string  the item that is being loaded
     * @param   mixed   any additional parameters
     * @param   string  an optional object name
     * @return  void
     */
    protected function _ci_events_class($class, $params = NULL, $object_name = NULL) {
        // Get the class name, and while we're at it trim any slashes.
        // The directory path can be included as part of the class name,
        // but we don't want a leading slash
        $class = str_replace('.php', '', trim($class, '/'));

        // Was the path included with the class name?
        // We look for a slash to determine this
        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE) {
            // Extract the path
            $subdir = substr($class, 0, $last_slash + 1);

            // Get the filename from the path
            $class = substr($class, $last_slash + 1);
        }

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class) {
            $subclass = APPPATH . 'events/' . $subdir . config_item('subclass_prefix') . $class . '.php';

            // Is this a class extension request?
            if (file_exists($subclass)) {
                $baseclass = BASEPATH . 'events/' . ucfirst($class) . '.php';

                if (!file_exists($baseclass)) {
                    log_message('error', "Unable to load the requested events class: " . $class);
                    show_error("Unable to load the requested events class: " . $class);
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($subclass, $this->_ci_loaded_files)) {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if (!is_null($object_name)) {
                        $CI = & get_instance();
                        if (!isset($CI->$object_name)) {
                            return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class . " class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($baseclass);
                include_once($subclass);
                $this->_ci_loaded_files[] = $subclass;

                return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
            }

            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;
            foreach ($this->_ci_events_paths as $path) {
                $filepath = $path . 'events/' . $subdir . $class . '.php';

                // Does the file exist?  No?  Bummer...
                if (!file_exists($filepath)) {
                    continue;
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($filepath, $this->_ci_loaded_files)) {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if (!is_null($object_name)) {
                        $CI = & get_instance();
                        if (!isset($CI->$object_name)) {
                            return $this->_ci_init_class($class, '', $params, $object_name);
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class . " events class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($filepath);
                $this->_ci_loaded_files[] = $filepath;
                return $this->_ci_init_class($class, '', $params, $object_name);
            }
        } // END FOREACH
        // One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
        if ($subdir == '') {
            $path = strtolower($class) . '/' . $class;
            return $this->_ci_load_class($path, $params);
        }

        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate == FALSE) {
            log_message('error', "Unable to load the requested events class: " . $class);
            show_error("Unable to load the requested events class: " . $class);
        }
    }
}
