<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

class Page_model extends JSON_Model {

	protected $path 		= PAGES_FOLDER;
	protected $navfile		= "index.json";
    protected $structure 	= [
        'id' => null,
        'title' => null,
        'url' => null
    ];

	private $_lexparser;
	
	function __construct()
	{
		parent::__construct();

		$this->_lexparser = new Lex\Parser();
	}

	function pluginList()
	{
		$path = './views/admin/plugins/';
		$folders = directory_map($path);
		$plugins = [];
		foreach ($folders as $folder => $isi) {
			if(in_array('meta.yml', $isi)){
				$meta = Yaml::parseFile($path.$folder.'meta.yml');
				$pagename = trim($folder,'/');
				$meta['custom_url'] = $meta['custom_url'] ?? 'admin/page/'.$pagename;
				$plugins[$pagename] = $meta;
			}
		}

		return $plugins;
	}

	function get_page($url = null, $parse = true)
	{
		// get page fields
		if(! $pagedata = $this->page_exist($url)){
			http_response_code(404);
			if(! $pagedata = $this->page_exist('404'))
				return false;
		}
		
		// get another md or html file as custom fields
		$files = scandir(PAGES_FOLDER.$pagedata['uri']);

		foreach ($files as $file) {
			if(is_dir(PAGES_FOLDER.$pagedata['uri'].'/'.$file)) continue;

			$filepath = pathinfo(PAGES_FOLDER.$pagedata['uri'].'/'.$file);

			// Get file with extension .md, .html and twig
			if(in_array($filepath['extension'], ['md','html','twig']))
			{
				// Get file content
				$pagedata[$filepath['filename']] = file_get_contents(PAGES_FOLDER.$pagedata['uri'].'/'.$file);

				// Especially for markdown content, parse it first
				if($filepath['extension'] == 'md'){
					$Parsedown = new Parsedown();
					$pagedata[$filepath['filename']] = $Parsedown->setBreaksEnabled(true)->text($pagedata[$filepath['filename']]);
				}

				// Prepare page files
				$pagedata['content_files_num'][] = $pagedata['uri'].'/'.$file;
				$pagedata['content_files'][$filepath['filename']] = $pagedata['uri'].'/'.$file;
			}
		}

		$pagedata['url'] = $pagedata['uri'];
		$file_segment = explode('/', $pagedata['uri']);
		if(! empty($pagedata['uri'])){
			$pagedata['slug'] = array_pop($file_segment);
			if(! empty($pagedata['uri']))
				$pagedata['parent'] = implode('/', $file_segment);
		}

		return $pagedata;
	}

	// --------------------------------------------------------------------
	/**
	 * search if page is exist
	 *
	 * @access	private
	 * @param	string	category, null for get all
	 * @param	int		page number
	 * @return	array
	 */
	function page_exist($url = null, $remain_uri = '')
	{
		if(file_exists(realpath(PAGES_FOLDER.$url.'/meta.yml')))
			$metaFile = realpath(PAGES_FOLDER.$url.'/meta.yml');
		else if(file_exists(realpath(PAGES_FOLDER.$url.'/index.yml')))
			$metaFile = realpath(PAGES_FOLDER.$url.'/index.yml');
		else {
			if(!empty($url)){
				$url = explode('/', $url);
				$remain = array_pop($url);
				$url = implode('/', $url);
				return $this->page_exist($url, $remain);
			}
			return false;
		}

		$pagedata = Yaml::parseFile($metaFile);
		$pagedata['uri'] = $url;

		// Accept next non-page uri as param or not 
		if(!empty($remain_uri))
			if(!($pagedata['accept_param_uri'] ?? false))
				return false;

		// merge page data to shared variables
		$this->shared = array_merge($this->shared, $pagedata);

		return $pagedata;
	}

	function page_detail($segments, $customdata = [], $return_as_string = false)
	{
		// pecah segment url
		$strseg = implode('/', $segments);

		// Ambil page, Kalo page 404 pun ga ada juga, show 404 bawaan ci
		if(! $page = $this->get_page($strseg)) show_404();

		// merge page data with custom data and also shared data
		$pagedata = [];
		$bootdata = [];
		if(file_exists('views/theme_child/pages/'.$page['uri'].'/boot.php'))
			$bootdata = include_once('views/theme_child/pages/'.$page['uri'].'/boot.php');
		else if(file_exists(PAGES_FOLDER.$page['uri'].'/boot.php'))
			$bootdata = include_once(PAGES_FOLDER.$page['uri'].'/boot.php');

		if(! is_array($bootdata)) $bootdata = ['boot' => $bootdata];

		// merge page data and other custom data
		$page = array_merge($page, $this->shared, $pagedata, $bootdata);

		return $page;
	}

	/**
	 * callback function for lex parser
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function _lex_callback($name, $attributes, $content)
	{
		$extension = explode(".", $name);
		$return = null;

		if(count($extension) >= 2)
		{
			list($extname, $func) = $extension;
			$classname = ucfirst($extname).'Shortcode';

			// callback from shortcode first
			if(file_exists(SHORTCODES_FOLDER.$classname.'.php'))
			{
				include_once SHORTCODES_FOLDER.$classname.'.php';
				$callbacks = new $classname();
				$callbacks->setAttributes($attributes);
				$data = $callbacks->{$func}();

				if(is_array($data))
				{
					$return = $this->_lexparser->parse($content, $data, array($this, '_lex_callback'));
				}
				else
					$return = $data;
			}
		}

		return $return;
	}

	function load_custom_data($segments)
	{
		$uri = implode('/', $segments);
		$path = PAGES_FOLDER.$uri.'/custom.php';
		if(file_exists($path))
			include_once(PAGES_FOLDER.$uri.'/custom.php');
		else
			$pagedata = [];

		return $pagedata;
	}

		/**
	 * scan page folders
	 *
	 * @access	public
	 * @param	array	array of page map, used for recursive
	 * @param	string 	parent url
	 * @return	array 	structured page map
	 */

	function scan_pages($map = false, $prefix = '', $depth = 5)
	{
		if(!$map)
			$map = directory_map(PAGES_FOLDER, $depth);

		$new_map = array();
		foreach ($map as $folder => $file)
		{
			// if this is subfolder
			if(is_array($file) && !empty($file) && !in_array(rtrim($folder,DIRECTORY_SEPARATOR), ['_trash','_draft'])) {
				$slug = $this->remove_extension($folder);
				$content = array(
					'title' => $this->guess_name($folder),
					'url' => $prefix.$slug,
					'children' => $this->scan_pages($file, $prefix.$slug.'/'),
					);

				if(empty($content['children']))
					unset($content['children']);
			
				$new_map[$slug] = $content;
			}

		}

		return $new_map;
	}

	function move_page($prevslug, $slug, $source, $dest)
	{
		// page move to another folder
		if($source != $dest) {
			// if it is move to subpage, not to root
			if(!empty($dest)) {
				// if parent still as standalone file (not in folder)
				if(file_exists(PAGES_FOLDER.$dest.'.md')) {
					// create folder and move the parent inside
					rename(PAGES_FOLDER.$dest.'.md', PAGES_FOLDER.$dest.'/index.md');

					// create index.html file
					// copy(PAGES_FOLDER.'index.html', PAGES_FOLDER.$dest.'/index.html');
				}
			}
		}

		// move to new location
		if(is_dir(PAGES_FOLDER.$source.'/'.$prevslug))
			rename(PAGES_FOLDER.$source.'/'.$prevslug, PAGES_FOLDER.$dest.'/'.$slug);
		else
			rename(PAGES_FOLDER.$source.'/'.$prevslug.'.md', PAGES_FOLDER.$dest.'/'.$slug.'.md');


		// if file left the empty folder, not from the root
		if(!empty($source) && $filesleft = glob(PAGES_FOLDER.$source.'/*')){

			// if there are only index.md
			if(count($filesleft) < 2){
				// move to upper parent
				$this->raise_page($source);
			}
		}

		return true;
	}

	function raise_page($source)
	{
		$parent_subparent_arr = explode("/", $source);
		$parent_name = array_pop($parent_subparent_arr);
		$parent_subparent = implode("/", $parent_subparent_arr);
		rename(PAGES_FOLDER.$source.'/index.md', PAGES_FOLDER.$parent_subparent.'/'.$parent_name.'.md');

		if(file_exists(PAGES_FOLDER.$source.'/index.html'))
			unlink(PAGES_FOLDER.$source.'/index.html');

		rmdir(PAGES_FOLDER.$source);
	}

	// --------------------------------------------------------------------

	/**
	 * get pages tree form page index file
	 *
	 * @access	public
	 * @param	array	array of page map, used for recursive
	 * @param	string 	parent url
	 * @return	array 	structured page map
	 */

	function get_pages_tree($prefix = false)
	{
		if(! file_exists(PAGES_FOLDER.'/'.$this->navfile))
			$this->sync_page();

		$map = json_decode(file_get_contents(PAGES_FOLDER.'/'.$this->navfile), true);

		// bulid the list
		return $map;
	}

	// --------------------------------------------------------------------

	/**
	 * Sync page index
	 *
	 * @access	public
	 * @return	array 	message
	 */
	function sync_page()
	{
		// create page if not exist
		if(! file_exists(PAGES_FOLDER.$this->navfile))
			write_file(PAGES_FOLDER.$this->navfile, json_encode(array(), JSON_PRETTY_PRINT));

		$output = array('status' => 'success', 'message' => 'Everything already synced.');

		if(!is_writable(PAGES_FOLDER))
			$output = array('status' => 'error', 'message' => "Page folder is not writable. Make it writable first.\n");

		// get current directory map
		$map = $this->scan_pages();

		// get the old page index
		$from_file = json_decode(file_get_contents(PAGES_FOLDER.$this->navfile), true);
		if(empty($from_file)) $from_file = array();

		// add new item to index
		$merge_diff = array_merge_recursive($from_file, $map);

		// remove unused item from index
		$new_index = array_intersect_assoc_recursive($merge_diff, $map);

		// make sure it is writablle
		if(! write_file(PAGES_FOLDER.$this->navfile, json_encode($new_index, JSON_PRETTY_PRINT))){
			$output = array('status' => 'error', 'message' => "Page index file ".$this->navfile." is not writable. Make it writable first.\n");
		}
		else
			$output = array('status' => 'success', 'message' => "Page index synced.\n");

		return $output;
	}

	/**
	 * Remove the extension from a file
	 * and also remove slash in folder name
	 *
	 * @access	public
	 * @param	string 	file name
	 * @return	string	file name without extension
	 */
	public function remove_extension($file)
	{
		if(is_string($file)){
			$segs = explode('.', $file, 2);
			if(count($segs) > 1)
			{
				array_pop($segs);
				$file = implode('.', $segs);
			}
		}


		return rtrim($file, DIRECTORY_SEPARATOR);
	}

	// --------------------------------------------------------------------------

	/**
	 * Check a valid extension file
	 *
	 * @access	public
	 * @param	string 	path/to/filename.ext
	 * @return	bool	true if it is a valid extension
	 */
	public function is_valid_ext($filepath)
	{
		if(is_file($filepath)){
			$part = pathinfo($filepath);
			if(! in_array($part['extension'], $this->allowed_ext))
				return false;

		}
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Remove the date from a file name
	 *
	 * @access	public
	 * @param	string 	filename
	 * @return	string	filename without date
	 */
	public function remove_date($filename)
	{
		$segs = explode('-', $filename, 6);

		if(count($segs) > 5)
		{
			$filename = $segs[5];
		}

		return $filename;
	}

	/**
	 * Guess Name
	 *
	 * Takes a file name and attempts to generate
	 * a human-readble name from it.
	 *
	 * @access	public
	 * @param	string 	file name
	 * @param	string 	starting folder to indicate is it blog post or else
	 * @retrun 	string
	 */
	public function guess_name($name, $prefix = null)
	{
		$name = $this->remove_extension($name);

		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);

		// assumes that root folders need uppercase first
		if(! $prefix)
			$name = ucfirst($name);

		return rtrim($name, '/');
	}

	/* BUILDER */

	// $type 	[header,footer,..]
	public function get_block_thumbnails($type = null)
	{
		if(!$type){
			$types = $this->get_blocklist();
			if(empty($types)) return [];

			foreach ($types['blocks'] as $block => $blockname) {
				$thumbnails[$block] = $this->get_block_thumbnails($block);
			}
		} else {
			$thumbPath = $this->shared['site_theme_path'].'/blocks/screenshots/';
			$htmlPath = $this->shared['site_theme_url'].'blocks/dist/';
			$thumbnails = [
				'thumbPath' => $this->shared['site_theme_url'].'blocks/screenshots/'.$type.'/',
				'thumbHtml' => $htmlPath,
				'thumbList' => []
			];
			if(! file_exists($thumbPath.$type)) return false;
			$thumbnails['thumbList'] = [
				'thumbs' => directory_map($thumbPath.$type, 1)
			];
		}

		return $thumbnails;
	}

	public function get_blocklist()
	{
		$path = $this->shared['site_theme_path'].'/blocks/dist/';
		if(! file_exists($path)) return false;

		$blockfiles = directory_map($path, 1);
		$block = [
			'path' => $path,
			'blocks' => []
		];
		foreach ($blockfiles as $file) {
			if(is_dir($path.$file)) continue;
			$info = pathinfo($path.$file);
			$block['blocks'][$info['filename']] = ucwords(str_replace("-", " ", $info['filename']));
		}
		unset($block['blocks']['css'],$block['blocks']['index']);
		return $block;
	}

	// Get Page template for post
	public function getTemplate()
	{
		
	}

}
