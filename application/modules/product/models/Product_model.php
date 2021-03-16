<?php

use Symfony\Component\Yaml\Yaml;

/**
 * Product Model
 * 
 * Product business model.
 * 
 * @author Oriza
 * @package Product
 */

class Product_model extends MY_Model
{
	public $table = 'products';
    public $protected = ['id'];
    public $fields = [
		'product_name' => [
			'field'=>'product_name',
			'label'=>'Product Name',
			'rules'=>'trim|required'
		],
		'product_slug' => [
			'field'=>'product_slug',
			'label'=>'Product Slug',
			'rules'=>'trim|required|alpha_dash|is_unique[products.product_slug]'
        ],
        'product_image' => [
			'field'=>'product_image',
			'label'=>'Product Image',
		],
		'product_desc' => [
			'field'=>'product_desc',
			'label'=>'Product Desc'
		],
		'product_type' => [
			'field'=>'product_type',
            'label'=>'Product Type',
            'rules'=>'trim|required'
        ],
        'normal_price' => [
			'field'=>'normal_price',
			'label'=>'Normal Price'
        ],
        'retail_price' => [
			'field'=>'retail_price',
			'label'=>'Retail Price'
		],
		'count_expedition' => [
			'field'=>'count_expedition',
			'label'=>'Expedition'
        ],
        'object_id' => [
			'field'=>'object_id',
			'label'=>'Object ID'
        ],
        'object_type' => [
			'field'=>'object_type',
			'label'=>'Object Type'
		],
		'publish' => [
			'field'=>'publish',
			'label'=>'Publish'
        ],
        'created_at' => [
            'field'=>'created_at',
			'label'=>'Created at'
        ],
        'updated_at' => [
            'field'=>'updated_at',
			'label'=>'Updated at'
        ],
        'member_id' => [
            'field'=>'member_id',
			'label'=>'User'
        ]
	];

	public $update_rules = [
		'product_name' => [
			'field'=>'product_name',
			'label'=>'Product Name',
			'rules'=>'trim|required'
		],
		'product_slug' => [
			'field'=>'product_slug',
			'label'=>'Product Slug',
			'rules'=>'trim|required|alpha_dash'
        ],
        'product_image' => [
			'field'=>'product_image',
			'label'=>'Product Image',
			'rules'=>'required'
		],
		'product_desc' => [
			'field'=>'product_desc',
			'label'=>'Product Desc'
		],
		'product_type' => [
			'field'=>'product_type',
            'label'=>'Product Type',
            'rules'=>'trim|required'
        ],
        'normal_price' => [
			'field'=>'normal_price',
			'label'=>'Normal Price'
        ],
        'retail_price' => [
			'field'=>'retail_price',
			'label'=>'Retail Price'
		],
		'count_expedition' => [
			'field'=>'count_expedition',
			'label'=>'Expedition'
        ],
        'object_id' => [
			'field'=>'object_id',
			'label'=>'Object ID'
        ],
        'object_type' => [
			'field'=>'object_type',
			'label'=>'Object Type'
		],
		'publish' => [
			'field'=>'publish',
			'label'=>'Publish'
        ],
        'created_at' => [
            'field'=>'created_at',
			'label'=>'Created at'
        ],
        'updated_at' => [
            'field'=>'updated_at',
			'label'=>'Updated at'
        ],
        'member_id' => [
            'field'=>'member_id',
			'label'=>'User'
        ]
	];

	public $soft_deletes = TRUE;

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get detail by field.
	 *
	 * @param string $field
	 * @param string $value
	 * @return array
	 */
	public function getProduct($field, $value = false)
	{
		$product = $this->where($field, $value)->as_array()->get();
        return $product;
	}

	// Get Product Type Object array, or just return array for dropdown 
	public function getProductTypes($as_dropdown = false)
	{
		$disabled = [];
        if(file_exists(SITEPATH.'configs/disabled_product_types.json'))
            $disabled = json_decode(file_get_contents(SITEPATH.'configs/disabled_product_types.json'));

		$types = [];
		$types_dropdown = [];
		foreach (modules_list() as $module => $detail) {
            if(file_exists($detail['path'].'ProductTypes')){
            	$files = directory_map($detail['path'].'ProductTypes', 1);
            	foreach ($files as  $file) {
            		$fileinfo = pathinfo($file);

            		// Skip disabled product type
            		if(in_array($fileinfo['filename'], $disabled)) continue;
            		
					$className = str_replace([SITEPATH,APPPATH,'/'], ["Site\\","App\\","\\"], $detail['path']).'ProductTypes\\'.$fileinfo['filename'];
					$typename = str_replace('ProductType', '', $fileinfo['filename']);
					$types[strtolower($typename)] = $className;
					$types_dropdown[strtolower($typename)] = $typename;
            	}
            }
        }

		if($as_dropdown)
			return $types_dropdown;

		return $types;
	}

	/**
	 * Fetch data
	 *
	 * @param string $perpage
	 * @param string $page
	 * @param array  $filter
	 * @param string $uri
	 * @return array
	 */
	public function getProducts($perpage = 10, $pagenum = 1, $filter = [], $uri = false)
	{
        $this->select('products.id, products.object_id, products.object_type, products.product_name, products.product_slug, products.product_type, products.product_image, products.product_desc, products.custom_data, products.normal_price, products.retail_price, products.count_expedition, products.active, products.publish');

        // Set constraint for total rows
		$this->_setFilter($filter);
		$total_rows = $this->count_rows();

		// Set constraint for result
		$this->_setFilter($filter);

		$this->order_by('products.created_at','desc');
        
        return $this->paginate($perpage, $total_rows, $pagenum, $uri);
    }

	/**
	 * Insert
	 *
	 * Insert product to DB.
	 * 
	 * @param array $data
	 * @return bool
	 */
	public function insertProduct($sets = [])
	{
        // Go
		$data = $this->set_form_data($sets)
				   ->validate()
				   ->insert();

		if ($data === false)
		{
			return [
				'status' => 'failed', 
				'message' => validation_errors()
			];
		}

		return [
			'status' => 'success', 
			'message' => 'Successfully added', 
			'data' => $data
		];
	}

	/**
	 * Update Product
	 * 
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function updateProduct($id, $sets = [])
	{
		$result = $this->set_form_data($sets)
					   ->validate('update')
					   ->where('id', $id)
					   ->update();

		if($result === FALSE){
			return [
				'status' => 'failed', 
				'message' => validation_errors()
			];
		}

		return [
			'status' => 'success', 
			'message' => 'Successfully updated.'
		];
	}

	/**
	 * Delete Product
	 * 
	 * @param int $id
	 * @return array
	 */
	public function deleteProduct($id)
	{
		$product = $this->get($id);

		$this->db->set('deleted_at', date("Y-m-d H:i:s"));
		$this->db->set('product_slug', $product['product_slug'].'_'.random_string());
		$this->db->where('id', $id)->update($this->table);

		if($this->db->affected_rows() == 0){
			return [
				'status' => 'failed', 
				'message' => 'Failed to delete'
			];
		}

		return [
			'status' => 'success', 
			'message' => 'Successfully deleted.'
		];
	}

	/**
	 * Get Product Meta
	 * 
	 * @param int $product_id
	 * @param string $table
	 * @return array
	 */
	public function getMeta($product_id, $table)
	{
		$meta = $this->db->where('product_id', $product_id)->get($table)->row_array();
		return $meta;
	}

	/**
	 * Insert Product Meta
	 * 
	 * @param array $data
	 * @param string $table
	 * @return int
	 */
	public function insertMeta($data, $table)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update Product Meta
	 * 
	 * @param array $data
	 * @param string $table
	 * @return int
	 */
	public function updateMeta($data, $table)
	{
		$this->db->where('product_id', $data['product_id'])->update($table, $data);
		return $this->db->affected_rows();
	}

	/**
	 * Delete Product Meta
	 * 
	 * @param int $product_id
	 * @param string $table
	 * @return int
	 */
	public function deleteMeta($product_id = false, $table)
	{
		if(! $product_id) return 0;

		$this->db->where('product_id', $product_id)->delete($table);
		return $this->db->affected_rows();
	}

	/**
	 * Set filter using like statement
	 *
	 * @param array $filter
	 * @return array
	 */
	private function _setFilter($filter = [])
	{
		$fields = [];
		foreach ($filter as $key => $value) {
			// use key with format filter_[field] only
			if(strpos($key, 'filter_') === 0 && !empty(trim($value))) {
				$fields[substr($key, 7)] = $value;
				
				// set filter
				$this->like(substr($key, 7), $value);
			}
		}

		return $fields;
	}
}
