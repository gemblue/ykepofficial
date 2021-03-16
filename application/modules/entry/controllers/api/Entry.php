<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends REST_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Entry_model');
        $this->load->helper('entry');

        $this->entry = $this->uri->segment(3);
        if(!isset(config_item('entries')[$this->entry])) show_404();
        $this->entryConf = config_item('entries')[$this->entry] ?? false;
        $this->Entrydata_model = setup_entry_model($this->entry);
	}

	public function index($entry)
	{
		$pagenum = $this->input->get('pagenum') ?? 1;
		$order_by = $this->input->get('orderby') ?? 'id';
		$order_direction = $this->input->get('direction') ?? 'asc';

        // Set config for pagination
        $perpage    = 10;
        $uri        = 'api/entry/'.$entry.'/';
        $total_rows = $this->Entrydata_model
                            ->setFilter()
                            ->count_rows();

        // Join model table
        if(!empty($this->Entrydata_model->has_one))
            foreach ($this->Entrydata_model->has_one as $relation_entry => $opt) {
                $withFunction = 'with_'.$relation_entry;
                $this->Entrydata_model->$withFunction($opt['filter'] .'|'.$opt['fields']);
            }

        // Get data, pagination and field list
        $this->Entrydata_model->setFilter()->order_by($order_by, $order_direction);
        $results = $this->Entrydata_model->order_by('created_at', 'desc')->paginate($perpage, $total_rows, $pagenum, $uri);

        $data['results'] = [];
        if($results){
            foreach ($results as $result) {
            	$EntryEntity = new App\modules\entry\models\EntryEntity($this->entry, $result);
            	$data['results'][] = $EntryEntity->asArray();
            }
        }

        $data['pagination'] = $this->Entrydata_model->all_pages;

		$this->response($data);
	}

	public function detail($post_id)
	{
		$this->load->model('post/Post_model');

        $post = $this->Post_model->getPost('publish', 'id', $post_id, 'array');
        $Parsedown = new ParsedownExtra();
		$post['content'] = $Parsedown->setBreaksEnabled(true)->text($post['content']);
		$post['published_at'] = time_ago($post['published_at']);
        
        $this->response($post);
	}

    public function dropdown()
    {
        $sort = $this->input->get('sort') ?? 'created_at';
        $order = $this->input->get('sortdir') ?? 'desc';
        $select = ['id'];
        if($caption = $this->input->get('caption'))
            array_push($select, $caption);

        $results = $this->Entrydata_model
                        ->select($select)
                        ->setFilter()
                        ->order_by($sort,$order)
                        ->getAll();

        $this->response($results);
    }

}		 
