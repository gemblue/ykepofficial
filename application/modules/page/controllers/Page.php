<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Page
 * 
 * Front controller of this CMS. This is default url handler for Mein.
 * Homepage/Post/Page/Detail/Tags/Category/Search/Modules/Static 
 */

class Page extends MY_Controller
{
	protected $cacheStatus = false;
	protected $whitelists = [
		'dashboard'
	];

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Run cache?
		if (!in_array($this->uri->segment(1), $this->whitelists)) {
			$this->cacheStatus = true;
		}
		
		$this->cacheStatus = false;
		
		if ($this->session->userdata('role_name') != 'Super' && setting_item('dashboard.maintenance_mode') == 'on'){
			$this->load->render('pages/maintenance/content.html');
			die;
		}

		$homepage = $_ENV['HOME_PAGE'] ?? 'home';
        if (! file_exists(PAGES_FOLDER . $homepage . '/meta.yml') 
        	&& ! file_exists(PAGES_FOLDER . $homepage . '/index.yml')) {
			show_error('Home page is not found. You can create static page named \'home\' in page folder.');
		}

		$uri = $this->uri->segment_array();

		// If root domain called, call homepage
        if (empty($uri)) {
        	// Get overrided homepage or use default
            $uri = [1 => ($this->shared['homepage'] ?? $homepage)];
        }

        // Manage cache
        $cacheName = 'page_'.implode('-', $uri);
		
		// Hard clear cache the page
        if ($this->input->get('clearcache')){
        	cache()->delete($cacheName);
        	redirect($this->uri->uri_string());
        }

        // Get cache if exist
        if (!$this->input->get('discache')) {
			if ($this->cacheStatus) {
				if ($cachePage = cache()->get($cacheName)){
					$this->output
							->set_output($cachePage)
							->_display();
					exit;
				}
			}
		}

        // Hack for showing first segment as detail article
		$this->load->model('post/Post_model');
		$this->load->model('post/Taxonomy_model');
		
		// Check for post in database
	    if ($this->Post_model->isExist('slug', $uri[1]) 
	    	|| isset($uri[2]) 
	    	&& $this->Post_model->isExist('slug', $uri[2])
	    ) {
			$this->single($uri[1], $uri[2] ?? null);
			return;
		}

		// Process static page in theme/pages/ folder
		$page = $this->Page_model->page_detail($uri);

		// If not logged in, send to login form
		if(($page['require_login'] ?? null) && !$this->ci_auth->isLoggedIn())
			redirect('user/login?red='.$this->uri->uri_string());
		
		// Check if request comes from restful api
		$http_accept = $_SERVER['HTTP_ACCEPT'] ?? 'application/json';
		if($page['uri'] == '404' && strpos($http_accept, 'html') === false)
		{
			$this->output->enable_profiler(false)
						 ->set_status_header(404)
						 ->set_content_type('application/json')
						 ->set_output(json_encode(['status' => 'failed', 'message' => 'Page not found']))
						 ->_display();
			exit;
		}
		
		// Finally, Render page
		$output = $this->load->render('pages/'.$page['content_files']['content'], $page, true);
		
		// Just set if cacheStatus true.
		if ($this->cacheStatus) {
			cache()->set($cacheName, $output, 300);
		}

		echo $output;
    }

	// Post detail shown in first segment slug
	public function single($category_slug = null, $slug = null)
	{
		if(!isset($slug))
		    $slug = $category_slug;
		
        // Get post
        $post = $this->Post_model->getPost(null, 'slug', $slug);

		if (empty($post))
			show_404();
		
        if (isPermitted('post/preview', 'post', [$post->author]))
        {
            if ($post->status != 'publish')
                $this->load->view('preview.html');
        }
        else 
        {
            if ($post->status != 'publish')
                show_404();
        }

		$this->Post_model->increaseTotalSeen($post->id);
		
		// Set thumbnail
		$data['thumbnail'] = $this->Post_model->getFeaturedImage($post->id, '700x350');
		
		// if ($this->template->is_template_exists($post->template) === true)
        $template = !empty($post->template) ? $post->template : 'default';
        $template = 'template_'.$template;
		
		// Get category, tags and comment data		
		$data['category'] = $this->Taxonomy_model->get_category($post->id, 'name');
        $data['tags'] = $this->Taxonomy_model->get_tags($post->id, 'array');
        $data['tag_sentences'] = $this->Taxonomy_model->get_tags($post->id, 'string');
        $data['comment_platform'] = $this->Setting_model->get('comment_platform');
        
        // Inject SEO.
        $data['page_title'] = $post->title;
        $data['meta_author'] = $post->name;
        $data['meta_description'] = !empty($post->intro) 
        							? $post->intro 
        							: strip_tags(substr($post->content, 0, strpos($post->content, "\n")));
        $data['og_image'] = $data['thumbnail'];
        
        $this->load->render($template, array_merge($data, (array) $post));
	}

}
