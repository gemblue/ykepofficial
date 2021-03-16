<?php namespace App\modules\files\libraries;

class LocalDriver implements FileManagerInterface {

	private $config;

	public function __construct(array $config)
	{
		$this->config = $config;

		if(!file_exists($this->config['upload_path']))
			mkdir($this->config['upload_path'], 0775, true);
	}

	public function list($path)
	{
		ci()->load->helper('directory');

        $files = directory_map($this->config['upload_path'] . $path, 1);
        if(!$files) return [];

        $output = [];
        foreach ($files as $file) {
        	$output[] = ['Key' => $path . '/'. $file];
        }

        return $output;
	}

	public function upload($file, $target, $mode = 'public')
	{
		return null;
	}

	public function delete($file)
	{
		return unlink($file);
	}

	public function fileExists($filepath)
	{
		return file_exists($this->config['upload_path'].$filepath);
	}

	public function resize($source, $target, $size)
    {
        $source_image = $source;
        $new_image = $this->config['upload_path'] . '/' . $size . '/' . $target;
        $dimension = explode('x', $size);
        
        ci()->load->library('image_lib');
        ci()->image_lib->initialize([
            'image_library' => 'gd2',
            'source_image' => $source_image,
            'create_thumb' => FALSE,
            'new_image' => $new_image,
            'maintain_ratio' => TRUE,
            'width' => $dimension[0],
            'height' => $dimension[1]
        ]);
        
        if (ci()->image_lib->resize())
        {
            ci()->image_lib->clear();
   
            return true;
        }

        return false;
    }

}