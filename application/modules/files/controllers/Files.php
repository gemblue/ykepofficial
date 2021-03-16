<?php

use App\modules\files\libraries\FileManagerFactory;

class Files extends Backend_Controller {
    
    public $upload_path;
    private $fileManager;
    private $fileManagerConfig;
    
    public function __construct()
	{
        parent::__construct();

        $this->output->enable_profiler(false);

        // Dependency
        $this->config->load('files/config');
        $this->load->library('Image');

        // FileManager class
        $fileManagerDriver = config_item('fileManagerDriver');
        
        $this->fileManagerConfig = config_item('fileManagerConfig')[$fileManagerDriver];
        $this->filemanager = (new FileManagerFactory)($fileManagerDriver, $this->fileManagerConfig);
        
        // Setup.
        $this->shared['fileManagerConfig'] = $this->fileManagerConfig;
        $this->upload_path = $this->fileManagerConfig['upload_path'];  

        // Prepare thumbnail folder
        $this->createThumbnailFolders();
    }

    public function index()
    {
        $files = $this->filemanager->list('original/' . $this->session->user_id);

        // Prepare filename without the 'original/' folder
        foreach($files as &$file){
            $file['Filename'] = str_replace('original/', '', $file['Key']);
        }

        $data = [
            'files' => $files,
            'field' => $this->input->get('field', 'featured_image')
        ];
        
        $this->load->view('home', $data);
    }

    public function upload()
    {
        $source_path = $this->upload_path . 'original/' . $this->session->user_id;
        $this->load->library('upload', [
            'upload_path' => $source_path,
            'allowed_types' => $this->fileManagerConfig['allowed_types'],
            'max_size' => 1000,
            'max_width' => 3000,
            'max_height' => 2000
        ]);
        
        if ( ! $this->upload->do_upload('file'))
        {
            $message = $this->upload->display_errors();
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'.  $message .'</div>');
        }
        else
        {
            $upload = $this->upload->data();
            
            // Upload original picture to Spaces.
            $this->filemanager->upload($source_path .'/'. $upload['file_name'], 'original/' . $this->session->user_id . '/' . $upload['file_name']);
            
            // Upload Thumbnail
            $thumbnail_versions = $this->fileManagerConfig['thumbnail_versions'];
            foreach($thumbnail_versions as $thumbnail_version)
                $this->filemanager->resize(
                    $source_path .'/'. $upload['file_name'], 
                    $this->session->user_id . '/' . $upload['file_name'], 
                    $thumbnail_version
                );
            
            $this->session->set_flashdata('message', '<div class="alert alert-success">Uploaded successfully</div>');  
            $this->session->set_userdata('uploaded_key', 'original/' . $this->session->user_id . '/' . $upload['file_name']);
            $this->session->set_userdata('uploaded_filename', $this->session->user_id . '/' . $upload['file_name']);
        }

        redirect('files');
    }

    public function delete()
    {
        $this->filemanager->delete($this->input->get('file_name'));

        redirect('files');
    }

    private function createThumbnailFolders()
    {
        $thumbnail_versions = $this->fileManagerConfig['thumbnail_versions'];
        $thumbnail_versions[] = 'original';
        
        foreach($thumbnail_versions as $thumbnail_version)
        {   
            $path = $this->upload_path . '/' . $thumbnail_version . '/' . $this->session->user_id; 
            
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }
        }
    }
}