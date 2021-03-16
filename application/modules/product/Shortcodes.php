<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Shortcode 
 *	
 * Shortcode for Product Module
 * 
 * @author Oriza
 */
class ProductShortcode extends LexCallback 
{
	public function list()
	{
        $this->load->model('product/Product_model');

        $type = $this->getAttribute('type', null);
        $filter = $this->input->get(null, true);
        
        if ($type) {
            $filter['filter_product_type'] = $type;
        }

        $perPage = $this->getAttribute('perpage', 10);
        $uri = $this->getAttribute('uri', $this->uri->uri_string());
        $pagenum = $this->getAttribute('pagenum_segment', count(explode('/', rtrim($uri,'/'))));
        
        $data['products'] = $this->Product_model->getProducts($perPage, $pagenum, $filter, $uri);
        $data['pagination'] = $this->Product_model->all_pages;

        return $data;
    }   

    public function types()
    {
        $this->load->model('product/Product_model');

        $product_types = $this->Product_model->getProductTypes();
        $data['types'] = [];
        foreach ($product_types as $key => $value) {
            $data['types'][] = array_merge($value, ['type_slug' => $key]);
        }
        unset($product_types);

        return $data;
    }

    public function item()
    {
        $this->load->model('product/Product_model');
        $id = $this->getAttribute('id');
        $slug = $this->getAttribute('slug');

        if($slug)
            $product = $this->Product_model->getProduct('product_slug', $slug);
        else if($id)
            $product = $this->Product_model->getProduct('id', $id);
        else
            show_error('id or product_slug must be defined in product.item shortcode');

        return $product;
    }

    public function isSubscribeActive()
    {
        $this->load->model('product/Subscription_model');
    
        $user_id = $this->getAttribute('user_id');
        $course_id = $this->getAttribute('course_id');
        
        return $this->Subscription_model->isSubscribeActive($user_id, $course_id, 'course');
    }

    public function setDiscountCookies()
    {
        $this->load->model('variable/Variable_model');

        $hours = $this->Variable_model->getItem('discount_hours');
        
        if(!isset($_COOKIE['DiscountDate'])) {
            
            $value = date("m/d/Y H:i:s", strtotime('+'. $hours .' hours'));

            setcookie("DiscountDate", $value, time()+(3600*24*14));  /* Expire in 14 days */
            
            return $value;
        } else {
            
            $discountTime = strtotime($_COOKIE['DiscountDate']);
            $now = strtotime(date('Y-m-d'));  

            if ($discountTime < $now)
                return null;
            
            return $_COOKIE['DiscountDate'];
        }
    }
}