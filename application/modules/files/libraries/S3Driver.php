<?php namespace App\modules\files\libraries;

class S3Driver implements FileManagerInterface {

	private $config;
	private $space;

	public function __construct(array $config)
	{
		$this->config = $config;

		$this->space = new \SpacesConnect($this->config['key'], $this->config['secret'], $this->config['space_name'], $this->config['region']);
	}

	public function list($path)
	{
        $files = $this->space->ListObjects($path);
        
        return $files;
	}

	public function upload($file, $target, $mode = 'public')
	{
        $result = $this->space->UploadFile($file, $mode, $target);
        
        return $result;
	}

	public function delete($file)
	{
        return $this->space->DeleteObject($file);
	}

	public function fileExists($filepath)
	{
		return $this->space->DoesObjectExist($filepath);
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
            // Upload ke DO Spaces
            $this->space->UploadFile($new_image, 'public', $size . '/' . $target);
            
            // Hapus gambar asli.
            unlink($new_image);

            ci()->image_lib->clear();
            
            return true;
        }

        return false;
    }

}