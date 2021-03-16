<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Entry extends Backend_Controller {
    
    private $Entrydata_model;
    private $entry;
    private $entryConf;

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Entry_model');

        $this->entry = $this->uri->segment(3);
        if(!isset(config_item('entries')[$this->entry])) show_404();

        $this->entryConf = config_item('entries')[$this->entry] ?? false;

        if(!$this->db->table_exists($this->entryConf['table']))
            show_error('Entry not installed.');

        $this->Entrydata_model = setup_entry_model($this->entry);
        if(isset($this->entryConf['soft_deletes'])) 
            $this->Entrydata_model->soft_deletes = $this->entryConf['soft_deletes'];

        $this->shared['current_module'] = $this->entry;
        $this->shared['entryConf'] = $this->entryConf;
    }
    
    public function index($entry = null)
    {
        $where_in_by_join = [];
        $exclude_filter = [];

        // Set config for pagination
        $perpage    = $this->input->get('perpage') ?? $this->entryConf['row_per_page'] ?? 10;
        $uri        = "admin/entry/$entry";
        $total_rows = $this->Entrydata_model
                            ->setFilter($exclude_filter, $where_in_by_join)
                            ->count_rows();

        // Join model table
        if(!empty($this->Entrydata_model->has_one))
            foreach ($this->Entrydata_model->has_one as $relation_entry => $opt) {
                $withFunction = 'with_'.$relation_entry;
                $this->Entrydata_model->$withFunction();
            }

        // Get data, pagination and field list
        $this->Entrydata_model->setFilter($exclude_filter, $where_in_by_join);

        $data['results'] = $this->Entrydata_model
                                ->order_by($_GET['sort'] ?? 'created_at', $_GET['sortdir'] ?? 'desc')
                                ->paginate($perpage, $total_rows, $_GET['page'] ?? 1, $uri, ['page_query_string'=>true]);
        $data['pagination'] = $this->Entrydata_model->all_pages;
        $data['show_on_table'] = $this->entryConf['show_on_table'] ?? null;
        $data['show_timestamps'] = $this->entryConf['show_timestamps'] ?? null;
        $data['fields'] = $this->entryConf['fields'];
        $data['action_buttons'] = $this->entryConf['action_buttons'] ?? false;
        
        $data['entry'] = $entry;
        $data['uri'] = $uri;
        $data['total'] = $total_rows;
        $data['page_title'] = $this->entryConf['name'];

        // Get Parent Data
        if(isset($this->entryConf['parent_module']) 
           && isset($this->entryConf['parent_module_filter_field'])
           && ($_GET['filter'][$this->entryConf['parent_module_filter_field']] ?? null) )
        {
            $classname = ucfirst($entry).'EntryActions';
            $methodName = 'getParentData';

            include_once(config_item('entry_config_path').$classname.'.php');
            $actionClass = new $classname();

            $params = [
                'parent_module' => $this->entryConf['parent_module'],
                $this->entryConf['parent_module_filter_field']
            ];
            $data['parent_data'] = call_user_func_array([$actionClass, $methodName], $params);
        }

        $this->view('admin/entry/index', $data);
    }

    public function add()
    {
        $data['page_title'] = 'New '.$this->entryConf['name'];
        $data['form_type']  = 'new';
        $data['action_url'] = site_url("admin/entry/{$this->entry}/insert/");
        $data['add_url'] = null;

        $data['fields'] = $this->entryConf['fields'];
        $data['entryConf'] = $this->entryConf;
        $data['entry'] = $this->entry;

		$this->view('admin/entry/form', $data);
    }
    
    public function edit($entry, $id = false)
	{
        if(!$id) show_404();

        $data['page_title'] = 'Edit '.$this->entryConf['name'];
        $data['form_type']  = 'edit';
        $data['action_url'] = site_url("admin/entry/{$this->entry}/update/".$id);
        $data['add_url'] = site_url("admin/entry/{$this->entry}/add/");

        $EntryRel_model = [];
        foreach ($this->entryConf['fields'] as $field => $fieldConf) {
            if(isset($fieldConf['relation']['entry'])){
                $withFunction = 'with_'.$fieldConf['relation']['entry'];
                $this->Entrydata_model->$withFunction();
            }
        }

        $data['result'] = $this->Entrydata_model->get($id);
        $data['fields'] = $this->entryConf['fields'];
        $data['entryConf'] = $this->entryConf;
        $data['entry'] = $this->entry;
        $data['id'] = $id;
        $this->view('admin/entry/form', $data);
    }

    public function insert()
    {
        if($result = $this->Entry_model->insert($this->entry))
        {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully added.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. validation_errors() .'</div>');        
            redirect(getenv('HTTP_REFERER'));
        } 


        redirect("admin/entry/{$this->entry}/edit/".$result['id'].'?'.$_SERVER['QUERY_STRING']);
    }

    public function update($entry, $id = false)
    {
        if(!$id) show_404();
        
        if($result = $this->Entry_model->update($this->entry, $id))
        {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully updated.</div>');
        
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. validation_errors() .'</div>');        
            redirect(getenv('HTTP_REFERER'));
        } 


        redirect("admin/entry/{$this->entry}/edit/".$id.'?'.$_SERVER['QUERY_STRING']);
    }

    public function delete($entry = false, $id = false)
    {
        if(!$entry || !$id) show_404();

        if($this->Entrydata_model->delete($id))
            $this->session->set_flashdata('message', '<div class="alert alert-success">Successfully deleted.</div>');
        else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Fail to delete data.</div>');

        redirect("admin/entry/$entry".'?'.$_SERVER['QUERY_STRING']);
    }

    public function confirm($entry = false, $type = 'row', $action = null, $id = null)
    {
        $data['entry'] = $entry;
        $data['entryConf'] = $this->entryConf;
        $data['action'] = $this->entryConf['action_buttons']['row'][$action];
        $data['fields'] = $this->entryConf['action_buttons']['row'][$action]['confirm']['fields'];
        $data['redirect'] = getenv('HTTP_REFERER');

        if($post = $this->input->post()){
            $this->action($entry, $type, $action);
        }

        $this->view('admin/entry/confirm_form', $data);
    }

    public function export_csv($entry = false)
    {
        $where_in_by_join = [];
        $exclude_filter = [];

        // Join model table
        if(!empty($this->Entrydata_model->has_one))
            foreach ($this->Entrydata_model->has_one as $relation_entry => $opt) {
                $withFunction = 'with_'.$relation_entry;
                $this->Entrydata_model->$withFunction();
            }

        // Get data, pagination and field list
        $this->Entrydata_model->setFilter($exclude_filter, $where_in_by_join);
                              // ->order_by('created_at', 'desc')
                              // ->order_by('id', 'asc');
        $results = $this->Entrydata_model->order_by('created_at', 'desc')->get_all();
        $fields = array_keys($this->entryConf['fields']);

        $fp = fopen(SITEPATH.'resources/csv/export_'.$entry.'.csv', 'w');

        fputcsv($fp, $fields);
        foreach ($results as $result) {
            $row = [];
            foreach ($fields as $field) {
                $row[$field] = trim(preg_replace('/\s+/', ' ', $result[$field]));
            }
            fputcsv($fp, $row);
        }

        fclose($fp);

        $this->load->helper('download');
        force_download(SITEPATH.'resources/csv/export_'.$entry.'.csv', null);
    }

    // Catch action from custom action button 
    public function action($entry = false, $type = false, $action_name = false)
    {
        if(!$entry || !$type || !$action_name) show_404();

        $params = array_slice($this->uri->segment_array(), 6);
        array_unshift($params, $this->Entrydata_model);

        $redirect = getenv('HTTP_REFERER');

        // Catch post data from confirm form
        if($post = $this->input->post()){
            array_push($params, $post);
            $redirect = $this->input->post('redirect') ?? $redirect;

            // Clear postdata to prevent merusak operasi di model
            $_POST = [];
        }

        $classname = ucfirst($entry).'EntryActions';
        $methodName = $type.'action_'.$action_name;

        include_once(config_item('entry_config_path').$classname.'.php');
        $actionClass = new $classname();

        $output = call_user_func_array([$actionClass, $methodName], $params);

        if($output)
            $this->session->set_flashdata('message', $output['message']);
        else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Action method not return message output.</div>');
        
        redirect($redirect);
    }
    
    public function update_relation()
	{
        // Get post.
        $post = $this->input->post();
        
        // Init.
        $relation_table = 'mein_entries_' . $post['entry'] . '_' . $post['relation'];
        $first_field = $post['entry'] . '_id';
        $second_field = $post['relation'] . '_id';

        // Trial, dirty code.
        if (!empty($post['choosen']))
        {
            foreach($post['choosen'] as $choosen => $value)
            {
                // Check redundancy
                $this->db->select('id');
                $this->db->from($relation_table);
                $this->db->where($first_field, $post['id']);
                $this->db->where($second_field, $value);
                
                $result = $this->db->get()->row();

                if (empty($result))
                {
                    $this->db->insert($relation_table, [
                        $first_field => $post['id'],
                        $second_field => $value,
                        'created_at' => date('y-m-d h:i:s')
                    ]);
                }
            }
        }

        echo 'done';
    }

    public function remove_relation($entry, $relation, $relation_id)
	{
        $this->Entry_model->remove_relation($entry, $relation, $relation_id);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Sucessfully removed.</div>');

        redirect($_GET['callback']);
    }
}
