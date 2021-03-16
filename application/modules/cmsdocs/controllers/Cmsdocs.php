<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmsdocs extends MY_Controller {

	public function __construct()
	{
        parent::__construct();

        $this->output->enable_profiler(false);
    }

    public function index()
	{
        // Create structure
        $docs = [];

        // Core docs
        $docs['site'] = $this->parseFolder('../docs/');

        // Module docs
        foreach($this->config->config['modules'] as $module => $detail){
            if(file_exists($detail['path'].'docs/')){
                $docs[$module] = $this->parseFolder($detail['path'].'docs/');
            }
        }
        
        // Site docs
        if(file_exists(SITEPATH.'docs/')){
            $docs['site'] = $this->parseFolder(SITEPATH.'docs/');
        }

        // Show content
        $uri = $this->uri->segment_array();
        
        // Remove first segment 'cmsdocs'
        array_shift($uri);

        if(isset($uri[2]))
            $current = $docs[$uri[0]][$uri[1]]['children'][$uri[2]];
        else if(isset($uri[1]))
            $current = isset($docs[$uri[0]][$uri[1]]['children'])
                        ? $docs[$uri[0]][$uri[1]]['children']['01-intro.md']
                        : $docs[$uri[0]][$uri[1]];
        else if(isset($uri[0]))
            $current = $docs[$uri[0]]['01-intro.md'];
        else
            $current = $docs['site']['01-intro.md'];

        $content = file_get_contents($current['path']);

        $this->load->render('index', compact('docs','content'));
	}

    private function parseFolder($path)
    {
        $data = [];
        $path = rtrim($path,'/').'/';
        if($map = directory_map($path, 1)){
            sort($map);
            foreach ($map as $i => $m) {
                $data[rtrim($m,'/')] = [
                    'path' => $path.$m,
                    'caption' => substr(str_replace('-', ' ', $m), 2, -3)
                ];
                if(is_dir($path.$m)){
                    $data[rtrim($m,'/')]['children'] = $this->parseFolder($path.$m);
                    $data[rtrim($m,'/')]['caption'] = substr(str_replace('-', ' ', $m), 2, -1);
                }
            }
        }
        return $data;
    }
    
}