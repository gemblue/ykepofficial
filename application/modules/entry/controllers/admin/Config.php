<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends Backend_Controller {

	public function __construct()
	{
        parent::__construct();

        $this->load->helper('entry/entry');
    }
    
	public function index()
	{
		$data['page_title'] = 'Entries Configuration';
        $data['action'] = site_url('admin/entry/config/update');
        $data['results'] = array_map(function($var){
            $fileinfo = pathinfo($var);
            if($fileinfo['extension'] == 'yml'){
                $info = pathinfo($this->Entry_model->entry_config_path.$var);
                $content = $this->Entry_model->get_entry_config($info['filename'], true, false);
                return array_merge($info, $content);
            }
        }, directory_map($this->Entry_model->entry_config_path, 1));

		$this->view('admin/config/list', $data);
	}

    public function init_entry($entry = false)
    {
        if($this->input->post('entry_name'))
            $entry = url_title($this->input->post('entry_name'), '_', true);
        
        if(empty($entry)) show_404();

        if(isset($this->config->config['modules'][$entry])){
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Entry name has been used as module. Try different name.</div>');
            redirect('admin/entry/config');
        }
        if(isset($this->config->config['entries'][$entry])){
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Entry name has been used by another entry. Try different name.</div>');
            redirect('admin/entry/config');
        }

        echo $template = $this->Entry_model->get_entry_config($entry, false);
        write_file($this->Entry_model->entry_config_path.$entry.'.yml', $template);
        redirect('admin/entry/config/form/'.$entry);
    }

    public function form($entry = '')
    {
        $data['page_title'] = 'Entries Configuration';
        $data['action'] = site_url('admin/entry/config/update');
        $data['entry_name'] = $entry;
        $data['content'] = $this->Entry_model->get_entry_config($entry, false);

        $this->view('admin/config/form', $data);
    }

	public function save()
	{
        $this->output->enable_profiler(false);

        $post = $this->input->post(null, true);

        if($this->Entry_model->update_db($post['oldname'],$post['name'],$post['entry'])){
            echo json_encode(['status' => 'success', 'message' => 'Entry saved.']);
            die();
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Entry fail to save.']);
            die();
        }   
    }

    public function sync($entry)
    {
        if(!$yaml = $this->Entry_model->get_entry_config($entry, false, false)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Entry not found.</div>');
            redirect('admin/entry/config/form/'.$entry);
        }

        if($this->Entry_model->sync($entry, $yaml)){
            $this->session->set_flashdata('message', '<div class="alert alert-success">Entry structure <strong>'.$entry.'</strong> synced successfully.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Entry structure <strong>'.$entry.'</strong> fail to synced.</div>');
        }

        redirect(getenv('HTTP_REFERER'));
    }

    public function getSelect2Dropdown()
    {
        $this->output->enable_profiler(false);
        $this->output->set_content_type('application/json');

        $keyword = $this->input->get('keyword', true);
        $table = $this->input->get('table', true);
        $caption_field = $this->input->get('caption_field', true);
        $search_field = $this->input->get('search_field', true);
        
        if(! $keyword)
            $results = [];
        
        else {
            $this->db->select('id, ' . implode(',',$caption_field))
                     ->from($table);

            foreach ($search_field as $sfield)
                $this->db->or_like($sfield, $keyword, 'both');

            $results = $this->db->limit(10)
                                ->get()
                                ->result_array();
        }

        $data['results'] = [];
        if($results){
            foreach ($results as $value) {
                $text = [];
                foreach ($caption_field as $cfield)
                    $text[] = $value[$cfield];

                $data['results'][] = [
                    'id' => $value['id'],
                    'text' => implode(' - ', $text),
                ];
            }
        }

        echo json_encode($data);
    }
}
