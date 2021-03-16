# Menggunakan Library Event

Library event digunakan untuk menyisipkan kode di tempat dimana kita tidak ingin mengganggu dependensi antar modul.

Sebagai contoh, pada file MY_Controller, kita ingin menjalankan kode program terkait modul tertentu, misalnya modul course. Bisa saja kita panggil kode modul course pada file MY_Controller, akan tetapi hal tersebut akan membuat MY_Controller punya ketergantungan pada modul course, padahal modul course bukan modul inti dari sistem mein. Sehingga akan menyebabkan broken pada site lain yang tidak menggunakan modul course. 

Solusinya adalah dengan menyisipkan event `trigger` pada file MY_Controller seperti ini:

```php
$this->event->trigger('MY_Controller.constructor');
```

Sehingga MY_Controller sekarang hanya punya ketergantungan pada library event. Adapun bila kita ingin menjalankan operasi yang berkaitan dengan modul addon seperti contohnya course, maka kita tinggal membuat file dengan nama Events.php di dalam folder modul course/ dan buat class dengan nama "[Namamodul]Events" lalu definisikan callback event di dalamnya:

```php
<?php

class ProductEvents {

	public $events = [
		'MY_Controller.constructor' => 'registerMembershipStatus'
	];

	public function registerMembershipStatus()
	{
		$ci = &get_instance();
		$ci->load->helper('product/path_product');
        $ci->shared['membership'] = membership_status($ci->session->user_id);
        unset($ci);
	}

}
```

Pertama-tama kita daftarkan dahulu event apa yang ingin didaftarkan callbacknya pada property `$events`. Pada contoh di atas, kita mendaftarkan callback `registerMembershipStatus` pada event `constructMYController`. Maka saat event `constructMYController` dijalankan (ditrigger) dari file MY_Controller, method `registerMembershipStatus()` dari class ProductEvents pun akan ikut dijalankan.

## Daftar Event Trigger

Adapun event trigger yang sudah terdaftar sejauh ini diantaranya:

### in core system

- `MY_Contoller.constructor`

### in modules

- `Subscription_model.isSubscribeActive`

Lengkapi list di atas bila kamu membuat event trigger baru.