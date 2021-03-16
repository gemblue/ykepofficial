<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
	public $theme;
	public $theme_path;
	public $theme_url;

	public function __construct()
	{
		// Set default theme
		$this->setTheme();
	}

	private function _preparePagedata($data)
    {        
        $data = array_merge($data, ci()->shared);

        // Set default meta title and description
        if(!isset($data['page_title']) || empty($data['page_title']))
            $data['page_title'] = site_config('current_modules')['name'] ?? site_config('current_modules');

        if(!isset($data['meta_description']) || empty($data['meta_description']))
            $data['meta_description'] = site_config('current_modules')['description'] ?? '';

        $title_separator = ci()->config->config['title_separator'] ?? '-';

        // Set Site title tag
        if(isset($data['page_title']))
            $data['title'] = $data['page_title'] . " $title_separator ". $data['site_title'];
        else
            $data['title'] = $data['site_title'];

        return $data;
    }

	// Set active theme and it's path & url
	public function setTheme($theme = null, $backend = false)
	{
		// set theme name and path, set default if not provided
		$this->theme = $theme ?? ci()->config->item('template.default_theme');
		$this->theme_path = 'views/'.$this->theme.'/';
		$this->theme_url = base_url('views/'.$this->theme.'/');

		// set child theme name and path
		$this->child_theme = ci()->config->item('template.child_theme');
		$this->child_theme_path = 'views/'.$this->child_theme.'/';
		$this->child_theme_url = base_url('views/'.$this->child_theme.'/');

		if($backend){
			// Override by admin theme
			ci()->shared['theme'] = $this->theme;
			ci()->shared['theme_path'] = $this->theme_path;
			ci()->shared['theme_url'] = $this->theme_url;
		} else {
			ci()->shared['theme'] = $this->theme;
			ci()->shared['theme_path'] = $this->theme_path;
			ci()->shared['theme_url'] = $this->theme_url;

			// Set site theme for frontend
			ci()->shared['site_theme'] = $this->theme;
			ci()->shared['site_theme_path'] = $this->theme_path;
			ci()->shared['site_theme_url'] = $this->theme_url;

			// Set child theme for frontend
			ci()->shared['child_theme'] = $this->child_theme;
			ci()->shared['child_theme_path'] = $this->child_theme_path;
			ci()->shared['child_theme_url'] = $this->child_theme_url;
		}
	}

	// check if custom template exists
	public function is_template_exists($custom_template)
	{
		// if post_id is passed, get first
		if(is_int($custom_template))
			$custom_template = ci()->Post_model->get_field_value('template', 'id', $post_id);

		// Check existing
		if(file_exists($this->theme_path.'/'.$custom_template.'.php'))
			return true;

		return false;
	}

	public function get_available_templates()
	{
		return $this->__get_custom_template($this->theme_path);
	}

	private function __count_custom_template($theme_path, $type)
	{
		if ($handle = opendir($theme_path))
		{
			$counter = 0;

			while (false !== ($entry = readdir($handle)))
			{
				if ($type == 'page') {
					$param = '/page-/';
				} else {
					$param = '/post-/';
				}

				$check = preg_match($param, $entry);

				if ($check == true)
				{
					$counter++;
				}
			}

			return $counter;
			closedir($handle);
		}
	}

	private function __get_custom_template($theme_path)
	{
		if ($handle = opendir($theme_path))
		{
			$data = null;

			while (false !== ($entry = readdir($handle)))
			{
				$param = '/my-page/';

				$check = preg_match($param, $entry);

				if ($check == true)
				{
					$data[] = str_replace('.php','',$entry);
				}
			}

			return $data;

			closedir($handle);
		}
	}

	// invalid method, must be refactor
	private function __is_custom_template_still_exist($theme_path, $post_template_name)
	{
		if ($handle = opendir($theme_path))
		{
			$counter = 0;

			while (false !== ($entry = readdir($handle)))
			{
				$param = '/'. $post_template_name .'/';

				$check = preg_match($param, $entry);

				if ($check == true)
				{
					$counter++;
				}
			}

			closedir($handle);

			if ($counter >= 1) 
				return true;
		}

		return false;
	}
}