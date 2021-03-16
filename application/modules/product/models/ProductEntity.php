<?php namespace App\modules\product\models;

use App\libraries\Entity;
use Whoops\Exception\ErrorException;

class ProductEntity extends Entity {

    public $id = null;
    public $product_name;
    public $product_slug;
    public $product_desc;
    public $product_image = 'https://via.placeholder.com/300x300';
    public $normal_price = 0;
    public $retail_price = 0;
    public $count_expedition = null;
    public $publish = 1;

    public $object_id = null;
    public $object_type = null;
    public $object_item;

    public $custom_data;
    public $product_type;

    public $productType;

    public function __construct($product_id=false)
    {
        parent::__construct();

        if($product_id) $this->get($product_id);
    }

    // Get product data from database
    public function get($product_id)
    {
        ci()->load->model('product/Product_model');
        $data = ci()->Product_model->getProduct('id', $product_id);
        
        if(empty($data))
            throw new ErrorException("Order data with id $product_id not found in database");

        $this->setProperty($data);
        $this->setProductType();
        $this->setMeta();

        return $this;
    }

    public function getBy($field, $value)
    {
        ci()->load->model('product/Product_model');
        $data = ci()->Product_model->getProduct($field, $value);
        

        if(empty($data)) return false;

        $this->setProperty($data);
        $this->setProductType();
        $this->setMeta();

        return $this;
    }

    // Set product data supplied to property
    public function setMeta($data = [])
    {
        // Set custom_data if $data supplied
        if($data) {
            $this->custom_data = $this->productType->prepareOptions($data);
            return $this;
        }

        ci()->load->model('product/Product_model');

        // Get from table meta if exist
        if(ci()->db->table_exists($this->productType->metaTable)){
            $this->custom_data = ci()->Product_model->getMeta($this->id, $this->productType->metaTable);
        } else {
            $this->custom_data = json_decode($this->custom_data, true);
        }
        
        $this->custom_data = $this->productType->prepareOptions($this->custom_data);
        
        // Add custom data as main property
        foreach ($this->custom_data as $field => $value) {
            if ($field != 'object_id') {
                $this->{$field} = $value;
            }
        }

        return $this;
    }

    // Set Product Type entity
    public function setProductType($type=null)
    {
        if($type) $this->product_type = $type;

        ci()->load->model('product/Product_model');
        $productTypes = ci()->Product_model->getProductTypes();

        // Set productType object
        $this->productType = new $productTypes[$this->product_type];

        // Make sure product type metaTable exist
        $this->productType->metaTable = $this->productType->metaTable ?? 'product_'.$this->product_type;

        return $this;
    }

    public function save()
    {
        ci()->load->model('product/Product_model');

        // Define data for insertion/updating
        $data = [
            'product_name' => $this->product_name,
            'product_image' => $this->product_image,
            'product_slug' => $this->product_slug,
            'product_desc' => $this->product_desc,
            'normal_price' => $this->normal_price,
            'retail_price' => $this->retail_price,
            'count_expedition' => $this->count_expedition,
            'object_id' => $this->object_id,
            'object_type' => $this->object_type,
            'product_type' => $this->product_type,
            'publish' => $this->publish,
            'member_id' => $this->member_id ?? null,
        ];

        // Product Type must be set first before inserting
        $this->setProductType();

        $metaTableExist = ci()->db->table_exists($this->productType->metaTable);
        
        // Set custom_data
        $data['custom_data'] = $this->productType->prepareOptions($this->custom_data);

        // If meta table not exist save to custom data field as json
        if(! $metaTableExist){
            $data['custom_data'] = json_encode($data['custom_data']);
        }

        // Insert or update
        if(! $this->id)
        {
            $result = ci()->Product_model->insertProduct($data);
            if($result['status'] == 'success') $this->id = $result['data']['id'];

            // Insert product meta only if meta table exist and custom data exist
            if($metaTableExist && !empty($custom_data)) {
                $custom_data['product_id'] = $this->id;
                ci()->Product_model->insertMeta($custom_data, $this->productType->metaTable);
            }
        
        } else {
            $result = ci()->Product_model->updateProduct($this->id, $data);

            // Update product meta only if meta table exist and custom data exist
            if($metaTableExist && !empty($custom_data)) {
                $custom_data['product_id'] = $this->id;
                ci()->Product_model->updateMeta($custom_data, $this->productType->metaTable);
            }
        }
        
        return $result;
    }

    public function delete()
    {
        ci()->load->model('product/Product_model');

        $result = false;
        if($this->id){
            $result = ci()->Product_model->delete($this->id);
            // Do not remove meta since product is soft-deleted
            // ci()->Product_model->deleteMeta($this->id, $this->productType->metaTable);
        }


        return $result;
    }

}
