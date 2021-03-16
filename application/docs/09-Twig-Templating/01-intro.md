# Templating View dengan Twig

Penjelasan lengkap terkait fitur Twig dapat dilihat pada website https://twig.symfony.com/doc/2.x/

## Render Twig View

Bila pada versi PHP kita menggunakan `$this->view()` untuk templating menggunakan PHP, maka untuk menggunakan Twig, kita panggil dengan `$this->load->render()`.

**controllers/Coba.php**

```php
class Coba extends MY_Controller {

	function index()
	{
		$data['page_title'] = 'Contoh Twig';
		$data['content'] = 'Selamat datang di twig templating!';
		$this->load->render('index', $data);
	}
}
```

**views/index.twig**

```html
<!DOCTYPE html>
<html>
<body>
	<h1>{{ page_title }}</h1>
	<p>{{ content }}</p>
</body>
<html>
```

## Membuat Template Layout

Kita dapat memisahkan layout halaman di file tersendiri agar file view dapat fokus hanya menampilkan konten saja.

**themes/temasaya/layouts/basic.twig**

```html
<!DOCTYPE html>
<html>
<body>
	{% block('content') %}
</body>
<html>
```

**views/index.twig**

```html
{% extends 'layouts/basic.twig' %}
{% block content %}
	<h1>{{ page_title }}</h1>
	<p>{{ content }}</p>
{% endblock %}
```

Setiap layout harus disimpan di dalam folder layouts/ pada folder tema yang digunakan.

## Membuat Template Partials

Kita dapat meng-include template lain berupa partials atau file lain yang ada di dalam folder tema.

**themes/temasaya/layouts/basic.twig**

```html
<!DOCTYPE html>
<html>
<head>
	{% include 'partials/head.twig' %}
</head>
<body>
	{% block('content') %}

	{% include 'partials/footer.twig' %}
</body>
<html>
```

**themes/temasaya/partials/head.twig**

```html
<meta charset="UTF-8">
<title>{{ title }}</title>
```

**themes/temasaya/partials/footer.twig**

```html
<p>Copyright &copy; 2018 My Website</p>
```

## Hirarki Template

MeinCMS mendaftarkan 3 folder template yang dapat digunakan oleh Twig untuk menyimpan file view, dengan urutan seperti berikut:

1. theme aktif
2. theme default
3. view di module

Twig akan mencari file view mulai dari urutan pertama baru kemudian mencari ke urutan selanjutnya. Twig akan menggunakan file view yang ditemukan pertama kali.