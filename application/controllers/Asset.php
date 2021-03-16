<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends MY_Controller {

    /**
     *  Load module asset
     */
    public function module()
    {
    	$this->output->enable_profiler(false);
    	
    	$segments = array_values($this->uri->segment_array());

    	// remove first two segments
    	array_shift($segments);
    	array_shift($segments);

    	$module = array_shift($segments);
    	$file = implode('/', $segments);

        load_module_asset($module, $file);
    }

}
