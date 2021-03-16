<?php namespace App\modules\product\libraries;

use App\modules\payment\models\OrderEntity;

abstract class ProductType {

	public $options = [];

	function __construct() {}

	public function prepareOptions($custom_data = [])
	{
		$data = [];
		if($custom_data)
			foreach ($this->options as $field => $option)
				$data[$field] = $custom_data[$field] ?? null;

		return $data;
	}

	// When order status set to pending
	public function onPending(OrderEntity $order){}

	// When order status set to canceled, expired or refund
	public function onCancel(OrderEntity $order){}
	public function onExpired(OrderEntity $order){}
	public function onRefund(OrderEntity $order){}

	// When order status set to settlement
	public function onSettlement(OrderEntity $order){}
	public function onCapture(OrderEntity $order){}

	// When order status set to process
	public function onProcess(OrderEntity $order){}

	// When order status set to shipped
	public function onShipped(OrderEntity $order){}

	// When order status set to done
	public function onDone(OrderEntity $order){}

}