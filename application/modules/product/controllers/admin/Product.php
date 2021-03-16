<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\modules\product\models\ProductEntity;
use App\modules\payment\models\OrderEntity;

class Product extends Backend_Controller 
{
	public function __construct()
	{
		parent::__construct();

        $this->load->model('Product_model');

        $this->shared['submodule'] = 'product';
	}

    /**
     * Show products
     */
	public function index($pagenum = 1)
	{
        $data['page_title'] = 'Products';
		
        $perPage = 20;
		$uri = 'admin/product/index';
        
        $filter = $this->input->get(null, true);
        $data['product_types'] = $this->Product_model->getProductTypes(true);
        $data['results'] = $this->Product_model->getProducts($perPage, $pagenum, $filter, $uri);
        $data['pagination'] = $this->Product_model->all_pages;
        
        $this->view('admin/product/list', $data);
	}
    
    /**
     * Show add form
     */
    public function add($choosen_product_type = 'path')
	{
	 	$data['page_title'] = 'New Product '.ucfirst($choosen_product_type);
        $data['form_type'] = 'new';
        $data['choosen_product_type'] = $choosen_product_type;
        $data['action_url'] = site_url('admin/product/insert');

        $product = new ProductEntity();
        $product->setProductType($choosen_product_type);
        $data['product'] = $product;

		$this->view('admin/product/form', $data);
    }
    
    /**
     * Show edit form
     */
    public function edit($id)
	{
        $data['form_type'] = 'edit';
        $data['action_url'] = site_url('admin/product/update/' . $id);
        
        $product = new ProductEntity($id);
        $data['product'] = $product;
        $data['choosen_product_type'] = $product->product_type;

		$data['page_title'] = 'Edit Product '.ucfirst($product->product_type);
		$this->view('admin/product/form', $data);
    }
    
    /**
     * Handling insert product.
     */
    public function insert()
	{
        $post = $this->input->post(null, true);

        $product = new ProductEntity();
        $product->setProductType($post['product_type']);
        
        // Set for old value purpose
        foreach($post as $p => $value){
            $product->$p = $value;
            $this->session->set_flashdata($p, $value);
        }

        // Set meta data
        $product->setMeta($post);

        $insert = $product->save();
        
        if ($insert['status'] == 'success') 
        {
            // Clear populated formdata
            unset($_SESSION['__flash']);

            $this->session->set_flashdata('message', '<div class="alert alert-success">'. $insert['message'] . '</div>');
            redirect('admin/product/edit/' . $insert['data']['id']);
        }
        
        $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $insert['message'] .'</div>');
        redirect('admin/product/add/'.$post['product_type']);
    }
    
    /**
     * Handling update product.
     */
    public function update($id)
	{
        $post = $this->input->post(null, true);

        $product = new ProductEntity($id);

        // Set data to object properties
        foreach($post as $p => $value){
            $product->$p = $value;
            $this->session->set_flashdata($p, $value);
        }

        // Set meta data
        $product->setMeta($post);

        $update = $product->save();
        
        // Redirect
        if ($update['status'] == 'success')
        {
            // Clear populated formdata
            unset($_SESSION['__flash']);
            
		    $this->session->set_flashdata('message', '<div class="alert alert-success">'. $update['message'] .'</div>');
        } else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $update['message'] .'</div>');
         
		redirect('admin/product/edit/' . $id);
	}

    /**
     * Handling delete.
     */
    public function delete($id)
    {
        $delete = $this->Product_model->deleteProduct($id);
        
        // Redirect
        if ($delete['status'] == 'success') 
            $this->session->set_flashdata('message', '<div class="alert alert-success">'. $delete['message'] .'</div>');
        else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $delete['message'] .'</div>');
        
        redirect('admin/product/');
    }
}