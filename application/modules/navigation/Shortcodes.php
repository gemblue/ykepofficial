<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *	Navigation Shortcode
 *	
 *  Theme api for Navigation feature
 */
class NavigationShortcode extends LexCallback {

	public function area($array = true)
	{
        $area = $this->getAttribute('area');

        if(! file_exists('./resources/navigations/'.$area.'.json')) return [];

        $content = file_get_contents('./resources/navigations/'.$area.'.json');
        $output = json_decode($content, true);

        if($output['status'] == 'publish')
    		return $this->output($output);

        return [];
    }

}