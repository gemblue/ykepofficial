<?php

class PostEvents {

	public $events = [
		'admin_navbar.submenu' => 'addPostTypeMenu'
	];

	public function addPostTypeMenu(&$params = [])
	{
		if(ci()->uri->segment(2) != 'post') return $params;
		
		ci()->load->model('post/Post_model');
		$posttypes = ci()->Post_model->getPostType();
		

		$submenu[] = [
			"submodule" => "post_post",
		    "url" => "admin/post/index/all/post",
		    "icon" => "file-text",
		    "caption" => "Posts",
		    "menu_permission" => "posttype_post",
		];

		foreach ($posttypes as $type => $options) {
			$submenu[] = [
				"submodule" => "post_".$type,
			    "url" => "admin/post/index/all/".$type,
			    "icon" => "file-text",
			    "caption" => $options['label'],
			    "menu_permission" => "posttype_".$type,
			];
		}

		$params = array_merge($submenu, $params);
	}

}