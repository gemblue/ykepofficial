# Fungsi di Twig

Fungsi ditulis menggunakan {{ fungsi(params) }}. Berikut adalah daftar fungsi yang sudah didukung oleh Twig:

- [attribute](https://twig.symfony.com/doc/2.x/functions/attribute.html)
- [block](https://twig.symfony.com/doc/2.x/functions/block.html)
- [constant](https://twig.symfony.com/doc/2.x/functions/constant.html)
- [cycle](https://twig.symfony.com/doc/2.x/functions/cycle.html)
- [date](https://twig.symfony.com/doc/2.x/functions/date.html)
- [dump](https://twig.symfony.com/doc/2.x/functions/dump.html)
- [include](https://twig.symfony.com/doc/2.x/functions/include.html)
- [max](https://twig.symfony.com/doc/2.x/functions/max.html)
- [min](https://twig.symfony.com/doc/2.x/functions/min.html)
- [parent](https://twig.symfony.com/doc/2.x/functions/parent.html)
- [random](https://twig.symfony.com/doc/2.x/functions/random.html)
- [range](https://twig.symfony.com/doc/2.x/functions/range.html)
- [source](https://twig.symfony.com/doc/2.x/functions/source.html)
- [template_from_string](https://twig.symfony.com/doc/2.x/functions/template_from_string.html)

MeinCMS sudah mendaftarkan fungsi lain yang juga dapat dipakai di Twig, yang dapat dilihat di dalam file mein/application/config/twig.php. Kamu dapat menambahkan fungsi yang didukung di dalam file konfigurasi tersebut:

```php
$config['twig_functions'] = [
	'site_url',
    'base_url',
    'current_url',
    'form_open',
    'set_value',
    'time_ago',
    'isPermitted',
    'ellipsize',
];
```

