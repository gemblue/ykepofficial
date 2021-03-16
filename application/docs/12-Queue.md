# Menggunakan Antrian

Adakalanya kita ingin mengeksekusi suatu task tapi tidak ingin membebani runtime sehingga menyita waktu pengguna. Untuk itu kita bisa menggunakan sistem antrian (queue) yang disediakan oleh MeinCMS. Sistem ini adalah sistem antrian sederhana memanfaatkan cron dan database.

## Setup Queue

Jalankan migration untuk membuat table `jobs` pada database.

Agar job antrian dieksekusi, tambahkan cron berikut pada sistem operasi:

```terminal
* * * * * php /var/www/codepolitan.local/mein command queue/runJobs
* * * * * sleep 20 && php /var/www/codepolitan.local/mein command queue/runJobs
* * * * * sleep 40 && php /var/www/codepolitan.local/mein command queue/runJobs
``` 

Cron di atas akan menjalankan queue setiap 20 detik sekali.

## Membuat Worker

Buat file PHP dengan nama [Nama]Worker.php di dalam folder mein/cli/worker/. Hanya satu method yang dibutuhkan untuk menjalankan job, yakni `runJob()`. Kamu boleh membuat method lain di dalamnya untuk mendukung proses runJob. Berikut ini contoh worker untuk menulis file ke dalam folder uploads/.

```php
<?php namespace App\cli\worker;

class SampleWorker extends BaseWorker {

	// Required method, will be called by Queue class
	// This method will execute the job
	public function runJob()
	{
		$data = $this->jobData;

		$ci = &get_instance();
		$ci->load->helper('file');
		$response = write_file('./uploads/'.$data['filename'], $data['content']);

		if($response){
			$output['status'] = "success";
			$output['message'] = "file created";
		} else {
			$output['status'] = "failed";
			$output['message'] = "file fail to create";
		}

        return json_encode($output);
	}
}
```

Pada worker di atas, kita menjalankan job menulis file, dimana ia memerlukan 2 buah data, yakni filename dan content. Data ini akan didapatkan dari kolom `payload` pada data dari dalam table `jobs`.

Perhatikan bahwa method `runJob()` wajib mengembalikan output dalam format json, dimana paling tidak ada satu index dengan nama `'status'` yang bernilai `'success'` atau `'failed'`. Data status ini diperlukan oleh queue untuk menentukan apakah proses eksekusi job berhasil atau gagal. **Kembalikan nilai status `'failed'` hanya apabila Kamu ingin mengulang eksekusi job!**.

## Menyimpan Data Antrian

Sekarang kita akan memasukkan antrian ke dalam tabel `jobs`. Pada class Queue sudah ada method `placeQueue()` yang berguna untuk menyimpan data ke dalam antrian.

```php
$payload = [
    'filename' => 'file-'.date('Y-m-d-H-i-s').'.txt',
    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam inventore aliquam, earum sunt! Tempore temporibus, nemo omnis est, provident blanditiis, dolor natus porro, iure rem harum fugiat esse eum a.'
];
$queue = new App\cli\Queue;
$queue->placeQueue('sample', $payload, 5, 300);
```

Kita kemudian membuat objek Queue dan memanggil method `placeQueue($type, $payload, $priority, $expire_after)`. Parameter `$type` digunakan untuk memberitahu queue worker mana yang akan digunakan, pada contoh di atas nilai `sample` berarti mengarah ke class SampleWorker. Parameter `$payload` untuk memuat payload, yakni data yang diperlukan untuk eksekusi job oleh worker. Parameter `$priority` adalah nilai 1-9 untuk menentukan prioritas eksekusi dari daftar antrian. Semakin kecil nilai semakin tinggi prioritasnya. Parameter `$expire_after` adalah durasi dalam detik masa kadalluwarsa job untuk terus diulang bila belum atau gagal dieksekusi.