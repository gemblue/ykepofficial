<?php

class MY_Controller extends CI_Controller
{
	// Init public shared variable for general use.
	public $shared;

	// Init layout file used as page layout
	public $layout;
	
	// Bootstrap!
	public function __construct()
	{
		// Run Sentry
		if($_ENV['CI_ENV'] == 'production' && isset($_ENV['SENTRY_DSN'])){
			Sentry\init(['dsn' => $_ENV['SENTRY_DSN']]);
		}

		parent::__construct();
		setlocale(LC_TIME, "id_ID.utf8", "id_ID", "id");
		date_default_timezone_set('Asia/Jakarta');
		
		header('X-Frame-Options: SAMEORIGIN');
		
		$this->load->database();

		// Load cache driver
		$this->load->driver('cache', ['adapter'=>'memcached', 'backup'=>'file']);
	
		// Load high dependency model
		$this->load->model([
			'setting/Setting_model',
			'entry/Entry_model'
		]);

		$this->layout = $this->config->item('template.default_layout');

		// Profiler
		$this->output->enable_profiler($_ENV['PROFILER'] ?? false);

   		// Get site config as shared data
		$this->shared['settings'] = $this->Setting_model->getAll();
		$this->shared = array_merge($this->shared, setting_items('site'));

		// load ci_auth library
		$this->load->library('user/Ci_auth');

		// Set shared attributes to config for use outside controller
		$this->config->set_item('entries', get_all_entry_configs());
		$this->config->set_item('modules', modules_list());
		$this->config->set_item('current_modules', $this->config->config['modules'][$this->load->currentModule()] ?? $this->load->currentModule());
		
		// Save site theme name to prevent overrided by admin theme
		$this->shared['site_url'] = site_url();
		$this->shared['base_url'] = base_url();
		$this->shared['submodule'] = '';

		// Get segment values
		for($i = 1; $i < 10; $i++) $this->shared['seg_'.$i] = $this->uri->segment($i);
		$this->shared['uri_string'] = $this->uri->uri_string();

		// set frontend theme
		$this->template->setTheme();

		// Define static page path
		if(! defined('PAGES_FOLDER')) define('PAGES_FOLDER', $this->shared['theme_path'].'pages/');

		// Set another else config
		$this->shared['current_url_encode'] = urlencode(base64_encode(current_url()));
		
		// Set logged in user data
		$this->shared['me'] = $this->ci_auth->isLoggedIn();
		$this->shared['session'] = $this->session->all_userdata();

		// Always update jwt token cookie
		$this->ci_auth->setJWTSession();

		// Run construct MYController event
		$this->event->trigger('MY_Controller.constructor');

		// Load libraries that need shared variables
        $this->load->model('page/Page_model');
	}

	// Simplify loading view with passing shared data
	public function view($view, $data = [], $return = false)
	{
		$data = array_merge($data, $this->shared);

		// Set default meta title and description
		if(!isset($data['page_title']) || empty($data['page_title']))
			$data['page_title'] = site_config('current_modules')['name'];

		if(!isset($data['meta_description']) || empty($data['meta_description']))
			$data['meta_description'] = site_config('current_modules')['description'];

		// Check view in child theme first 
		if(file_exists($this->shared['child_theme_path'].'/'.$view.'.php')){
			$data['content'] = $this->load->view($this->shared['child_theme'].'/'.$view, $data, true);
		}

		// Check view in custom theme first 
		if(file_exists($this->shared['site_theme_path'].'/'.$view.'.php')){
			$data['content'] = $this->load->view($this->shared['site_theme'].'/'.$view, $data, true);
		}
		
		elseif(file_exists($this->shared['theme_path'].'/'.$view.'.php')){
			$data['content'] = $this->load->view($this->shared['theme'].'/'.$view, $data, true);
		}
		// Show view from module itself or default view 
		elseif(! is_null($view)){
			$data['content'] = $this->load->view($view, $data, true);
		}

		// else
		// if $view is null, it means that $data['content'] has already defined :)

		if(isset($data['layout'])) $this->layout = $data['layout'];
		
		$this->load->view_layout($this->layout, $data, false, $data['theme']);
	}

}

// Load Backend Controller
include_once('Cli_Controller.php');
include_once('Backend_Controller.php');
include_once('REST_Controller.php');
