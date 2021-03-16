<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entry
 * 
 * @author Oriza
 * @package Entry
 */

class Entry extends MY_Controller
{
    private $Entrydata_model;
    private $entry;
    private $entryConf;

	public function __construct()
	{
        parent::__construct();

        $this->load->model('Entry_model');
    }

    public function init_entry($entry)
    {
        $this->entry = $entry;

        if(isset(config_item('entries')[$this->entry]))
        {
            $this->entryConf = config_item('entries')[$this->entry] ?? false;
            
            if($this->entryConf)
                $this->Entrydata_model = setup_entry_model($this->entry);
    
            if(isset($this->entryConf['soft_deletes'])) 
                $this->Entrydata_model->soft_deletes = $this->entryConf['soft_deletes'];
        }
    }


    
    /**
     * Public handler for entry form.
     * 
     * @return mixed
     */
    public function insert()
    {
        $post = $this->input->post(null, true);
        
        $entry = $post['entry'];
        $this->init_entry($entry);

        $redirect = $post['redirect'] ?? null;
        unset($post['entry'], $post['redirect']);

        if($this->entryConf['set_owner'] ?? false)
            $post['owner'] = $this->session->userdata('user_id') ?? '0';

        // Set default value if field is empty
        $post = $this->_prepDefaultValue($post);
        
        // Before insert trigger
        $post = $this->_runActionEvent('before_insert', $post);

        $result = $this->Entrydata_model->validate()->insert($post);
        if(isset($result['id']))
        {
            // After insert trigger
            $post['id'] = $result['id'];
            $post = $this->_runActionEvent('after_insert', $post);

            // Reset input value
            $_SESSION['__flash'] = [];
            $_SESSION['__ci_vars'] = [];
            
            $this->session->set_flashdata('message', '<div class="alert alert-success">'.$this->session->success_message.'</div>');

            if($redirect){
                $this->load->library('parser');
                $url = $this->parser->parse_string($redirect, $post, true);
                redirect($url);
            }
        }
        else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            $this->session->set_flashdata('errors', _get_validation_object()->error_array());
        }

        redirect($_SERVER['HTTP_REFERER'] . '#form' . $entry);
    }

    public function upload($entry = false)
    {
        if(!$entry)
            json_encode(['success' => false, 'msg' => 'Entry is not defined.']);

        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']      = 2048;
        // $config['max_width']     = 1024;
        // $config['max_height']    = 768;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('uploadfile'))
        {
            $filedata = $this->upload->data();
            $output = json_encode(['success' => true, 'file' => $filedata['file_name']]);
        }
        else
        {
            $output = json_encode(['success' => false, 'msg' => $this->upload->display_errors('','')]);
        }

        exit($output);
    }

    // Catch action from custom action button 
    public function action($entry = false, $type = false, $action_name = false)
    {
        if(!$entry || !$type || !$action_name) show_404();

        $params = array_slice($this->uri->segment_array(), 5);

        $this->init_entry($entry);
        array_unshift($params, $this->Entrydata_model);

        $classname = ucfirst($entry).'EntryActions';
        $methodName = $type.'action_'.$action_name;

        include_once(SITEPATH.'resources/entries/'.$classname.'.php');
        $actionClass = new $classname();

        $output = call_user_func_array([$actionClass, $methodName], $params);

        if($output)
            $this->session->set_flashdata('message', $output['message']);
        else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Action method not return message output.</div>');

        redirect('admin/entry/index/'.$entry);
    }

    // Hook events
    private function _runActionEvent($event, $post)
    {
        $classname = ucfirst($this->entry).'EntryActions';
        $methodName = $this->entryConf['action_events'][$event] ?? null;
        $output = $post;

        if($methodName)
        {
            include_once(SITEPATH.'resources/entries/'.$classname.'.php');
            $actionClass = new $classname();

            $params = [$this->Entrydata_model, $post];
            $output = call_user_func_array([$actionClass, $methodName], $params);
        }

        return $output;
    } 

    private function _prepDefaultValue($post)
    {
        foreach ($this->entryConf['fields'] as $field => $conf) {
            if(! ($post[$field] ?? null))
                $post[$field] = $conf['default'] ?? null;
        }
        
        return $post;
    }

    function tes()
    {
        $data = [
            'nama' => 'Toni', 
            'alamat' => 'Bandung'
        ];
        extract($data);
        include(SITEPATH.'resources/email_templates/pendaftaran_training.php');
    }
}
