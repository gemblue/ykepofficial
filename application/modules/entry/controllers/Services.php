<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entry API
 * 
 * Segala endpoint API terkait entry
 */

class Services extends REST_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Entry_model');
        $this->load->helper('entry');

        $this->entry = $this->uri->segment(4);
        
        // Check entry config first.
        if (!isset(config_item('entries')[$this->entry])) {
            $this->response(['status' => 'failed', 'message' => 'Entry is not setted'], 200);
        }
        
        $this->entryConf = config_item('entries')[$this->entry] ?? false;
        $this->Entrydata_model = setup_entry_model($this->entry);
        $this->Entrydata_model->soft_deletes = true;
    }

    /**
     * Show all entry
     */
	public function index($entry)
	{
        $pagenum = $this->input->get('pagenum') ?? 1;
		$order_by = $this->input->get('orderby') ?? 'id';
		$order_direction = $this->input->get('direction') ?? 'asc';
		$where_in_by_join = [];
        $exclude_filter = [];

        // Join model table
        /*
        if (!empty($this->Relation_model)) {
            foreach ($this->Relation_model as $relation_entry => $opt) {
                $local_key = $opt['options']['local_key'];
                $exclude_filter[] = $local_key;
                $modelName = $opt['modelName'];
                if($filter_value = $_GET['filter'][$local_key] ?? null){
                    $filter_field = $this->entryConf['fields'][$local_key]['relation']['caption'];
                    $result = $this->$modelName->like($filter_field, $filter_value)->get_all();
                    foreach ($result as $value)
                        $where_in_by_join[$local_key][] = $value['id'];
                }
            }
        } */

        // Set config for pagination
        $perpage    = 10;
        $uri        = 'api/entry/' . $entry . '/';
        $total_rows = $this->Entrydata_model
                            ->setFilter()
                            ->count_rows();

        // Join model table
        if (!empty($this->Entrydata_model->has_one)) {
            foreach ($this->Entrydata_model->has_one as $relation_entry => $opt) {
                $withFunction = 'with_' . $relation_entry;
                $this->Entrydata_model->$withFunction($opt['filter'] .'|'.$opt['fields']);
            }
        }

        // Get data, pagination and field list
        $this->Entrydata_model->setFilter()->order_by($order_by, $order_direction);
        $results = $this->Entrydata_model->order_by('created_at', 'desc')->paginate($perpage, $total_rows, $pagenum, $uri);
        
        if (!$results) { 
            $this->response(['status' => 'failed', 'message' => 'There is no data'], 201);
        }

        $data = [
            'status' => 'success',
            'results' => []
        ];
        
        foreach ($results as $result) {
        	$EntryEntity = new App\modules\entry\models\EntryEntity($this->entry, $result);
        	$data['results'][] = $EntryEntity->asArray();
        }

        $data['pagination'] = $this->Entrydata_model->all_pages;

		$this->response($data);
    }

    /**
     * Insert entry
     */
    public function insert($entry)
    {
        $_POST['owner'] = 0;
        
        if ($result = $this->Entry_model->insert($entry))
        {
            $this->response(['status' => 'success', 'message' => 'Successfully inserted']);
        } 

        $this->response(['status' => 'failed', 'message' => 'Failed to insert']);
    }
    
    /**
     * Update entry
     */
    public function update($entry, $id = false)
    {
        if (!$id) {
            show_404();
        }
        
        if ($result = $this->Entry_model->update($entry, $id))
        {
            $this->response(['status' => 'success', 'message' => 'Successfully edited']);
        } 

        $this->response(['status' => 'failed', 'message' => 'Failed to edit']);
    }

    /**
     * Show detail
     */
	public function detail($entry, $id)
	{
        $result = $this->Entry_model->get_detail($entry, $id);
        
        if (!$result) {
            $this->response(['status' => 'failed', 'message' => 'There is no result']);
        }

        $this->response(['status' => 'success', 'result' => $result]);
    }

    /**
     * Delete
     */
    public function delete($entry, $id) {

        if (!$entry || !$id) {
            show_404();
        }

        $Entry = setup_entry_model($entry);
        $Entry->soft_deletes = true;

        $delete = $Entry->delete($id);

        if ($delete) {
            $this->response(['status' => 'success', 'message' => 'Successfully deleted']);
        }

        $this->response(['status' => 'failed', 'message' => 'Failed to delete']);
    }
}		 