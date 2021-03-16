# Product Entity

editor: Toni Haryanto

Untuk mendukung berbagai jenis tipe produk selain path kedepannya, gw udah bikin class ProductEntity yang disimpan di dalam file `models/ProductEntity.php` pada modul product. 

ProductEntity ini mewakili satu objek product. Class ini digunakan setiap kali kita hendak beroperasi dengan satu buah data product. Semua data product dimuat dalam bentuk properties dan bisnis prosesnya dikemas dalam bentuk method terenkapsulasi dalam class ini. 

Sementara gw udah bikin property dan method untuk mendukung penggunaan bisnis proses per tipe produk.

## Product Type

Di modul product ada folder ProductTypes yang berisi class-class yang mendefinisikan berbagai tipe produk dan bisnis prosesnya ketika status order diperbaharui. Class utamanya adalah ProductType.php yang merupakan abstract class dan menjadi parent untuk class-class tipe produk lainnya.

Struktur dasarnya seperti ini:

```php
<?php namespace App\modules\product\ProductTypes;

use App\modules\payment\models\OrderEntity;

abstract class ProductType {

	function __construct() {}

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
```

Method-method di atas nantinya dapat diisi oleh bisnis proses yang yang harus dijalankan setiap kali status order berubah. Misalnya, status dari suatu order diubah dari pending ke settlement, maka sistem akan menjalankan juga method `onSettlement()` pada class ini atau class turunannya sesuai tipe produknya.

Untuk saat ini baru PathProductType.php yang berjalan, menyesuaikan dengan sistem yang sudah berjalan. Silakan lihat file tersebut untuk mengamati ada kode seperti apa di dalamnya.