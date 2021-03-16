<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image
{
	public $ci;
	
	public function __construct()
	{
		// Get Codeigniter Instance
        $this->ci =& get_instance();
        $this->ci->load->library('image_lib');
    }

    public function resize($upload_path, $file_name, $width, $height)
    {
        $source_image = $upload_path . '/' . $file_name;
        $new_image = $upload_path . '/' . $width .'x' . $height. '/' . $this->ci->session->user_id . '/' . $file_name;
        
        $this->ci->image_lib->initialize([
            'image_library' => 'gd2',
            'source_image' => $source_image,
            'create_thumb' => FALSE,
            'new_image' => $new_image,
            'maintain_ratio' => TRUE,
            'width' => $width,
            'height' => $height
        ]);
        
        if ($this->ci->image_lib->resize())
        {
            $space = new SpacesConnect($this->ci->config->item('key'), $this->ci->config->item('secret'), $this->ci->config->item('space_name'), $this->ci->config->item('region'));
        
            // Upload ke DO Spaces
            $space->UploadFile($new_image, 'public', $width .'x' . $height . '/' . $this->ci->session->user_id . '/' . $file_name);
            
            // Hapus gambar asli.
            unlink($new_image);

            $this->ci->image_lib->clear();
            
            return true;
        }

        return false;
    }
}