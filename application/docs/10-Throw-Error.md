# Throw Error

MeinCMS sudah mengintegrasikan package filp/whoops untuk menampilkan pesan error yang lebih komprehensif daripada bawaaan CodeIgniter. Untuk itu, bila ingin menampilkan pesan error, sebaiknya jangan menggunakan fungsi show_error() bawaan CodeIgniter, tapi gunakan throw Exception.

Cara paling sederhana untuk menampilkan pesan error adalah seperti ini:

```php
if(empty($rules))
    throw new Exception("Rules is not defined");
```