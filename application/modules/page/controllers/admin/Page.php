<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cms
 *
 * Simple tool for making simple sites.
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2011-2012, Nyankod
 * @license		http://nyankod.com/license
 * @link		http://nyankod.com/pusakacms
 */

class Page extends Backend_Controller {

	function __construct()
	{
		parent::__construct();

		$this->viewpath = './views/admin/';
	}

	/*********************************************
	 * CUSTOM ADMIN PAGES
	 **********************************************/
	function index($plugin = null)
	{
		if(!$plugin) show_404();

		$pluginpath = $this->viewpath.'plugins/'.$plugin;
		if(! (config_item('plugins')[$plugin] ?? null)) show_error("Custom page $plugin not found.");

		// Set this to set active in sidebar menu
		$this->shared['current_module'] = $plugin;

		$meta = config_item('plugins')[$plugin];
		$data['page_title'] = $meta['name'];

		// merge page data with custom data and also shared data
		$bootdata = [];
		if(file_exists($pluginpath.'/boot.php'))
			$bootdata = include_once($pluginpath.'/boot.php');

		// merge page data and other custom data
		$data = array_merge($meta, $this->shared, $bootdata);

		$data['content'] = $this->load->render('plugins/'.$plugin.'/content', $data, true);

		$this->view('admin/page/index', $data);
	}

	function edit()
	{
		$segs = $this->uri->uri_string();
		// explode to get page slug
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3])){
			$parent = explode("/", $seg_array[3]);
			$prevslug = array_pop($parent);
			$parent = implode("/", $parent);
		}
		else
			show_404();

		$prevpage = $this->Page_model->get_page($seg_array[3], false);
		if(!isset($prevpage['slug']))
			$prevpage['slug'] = $prevslug;

		$this->form_validation->set_rules($this->page_fields);

		if($this->form_validation->run()){
			$page = $this->input->post();

			$page['parent'] = $prevpage['parent'] = $parent;

			// prepend and append brackets for array type field
			$page['role'] = preg_split('/[\ \n\,]+/', $page['role']);
			$page['meta_keywords'] = preg_split('/[\ \n\,]+/', $page['meta_keywords']);
			
			// update page content
			if($this->Page_model->update_page($page, $prevpage))
				$this->session->set_flashdata('success', 'Page updated.');
			else
				$this->session->set_flashdata('error', 'Page failed to update. Make sure the folder '.PAGES_FOLDER.' is writable.');

			if($this->input->post('btnSaveExit'))
				redirect('admin/page');
			else
				redirect('admin/page/edit/'.$parent.'/'.$page['slug']);
		}

		$data['form_type'] = 'edit';
		$data['page'] = $prevpage;
		$data['parent'] = $parent;
		$data['url'] = $parent.'/'.$prevpage['slug'];

		$this->view('admin/page/form', $data);
	} 

	function delete()
	{
		$segs = $this->uri->uri_string();
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3]))
			$prevslug = $seg_array[3];
		else
			show_404();

		$source_arr = explode("/", $prevslug);
		$page = array_pop($source_arr);
		$source = implode("/", $source_arr);

		if($this->Page_model->move_page($page, $page, $source, '_trash')){
			$this->session->set_flashdata('success', 'Page '.$prevslug.' deleted.');

			// check to raise parent page
			$slug_array = explode("/", $prevslug);
			if(count($slug_array) >= 2){
				array_pop($slug_array);
				$parent = implode("/", $slug_array);
				$this->Page_model->raise_page($parent);
			}

			// update page index
			$this->sync(false);
		}
		else
			$this->session->set_flashdata('error', 'Page failed to delete. Make sure the folder '.PAGES_FOLDER.' is writable.');

		redirect('admin/page');
	}
}
