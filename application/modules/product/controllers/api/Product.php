<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Services 
 *
 * @author Oriza 
 * @package Product
 */

class Product extends REST_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->output->enable_profiler(false);
        $this->load->model('product/Product_model');
    }

	/**
     * Show products
     */
    public function index($pagenum = 1)
    {
        $perPage = 16;
        $uri = 'api/product/index/';
        
        $filter = $this->input->get(null, true);
        $data['data'] = $this->Product_model->getProducts($perPage, $pagenum, $filter, $uri);
        $data['pagination'] = $this->Product_model->all_pages;
        
        $this->response($data);
    }

    /**
     * Show products
     */
    public function detail($id)
    {
        $data['product'] = $this->Product_model->getProduct('id', $id);
        $data['status'] = $data['product'] ? 'success' : 'failed';

        $this->response($data);
    }

}