# Filter di Twig

Filter ditulis menggunakan {{ var|namafilter }}. Bila filter memerlukan parameter lebih dari satu, maka ditulis seperti fungsi dan parameter pertama menggunakan variabel yang ditulis di depannya, seperti ini {{ var|namafilter(var2, var3) }}. Berikut adalah daftar filter yang sudah didukung oleh Twig:

- [abs](https://twig.symfony.com/doc/2.x/filters/abs.html)
- [batch](https://twig.symfony.com/doc/2.x/filters/batch.html)
- [capitalize](https://twig.symfony.com/doc/2.x/filters/capitalize.html)
- [convert_encoding](https://twig.symfony.com/doc/2.x/filters/convert_encoding.html)
- [date](https://twig.symfony.com/doc/2.x/filters/date.html)
- [date_modify](https://twig.symfony.com/doc/2.x/filters/date_modify.html)
- [default](https://twig.symfony.com/doc/2.x/filters/default.html)
- [escape](https://twig.symfony.com/doc/2.x/filters/escape.html)
- [first](https://twig.symfony.com/doc/2.x/filters/first.html)
- [format](https://twig.symfony.com/doc/2.x/filters/format.html)
- [join](https://twig.symfony.com/doc/2.x/filters/join.html)
- [json_encode](https://twig.symfony.com/doc/2.x/filters/json_encode.html)
- [keys](https://twig.symfony.com/doc/2.x/filters/keys.html)
- [last](https://twig.symfony.com/doc/2.x/filters/last.html)
- [length](https://twig.symfony.com/doc/2.x/filters/length.html)
- [lower](https://twig.symfony.com/doc/2.x/filters/lower.html)
- [merge](https://twig.symfony.com/doc/2.x/filters/merge.html)
- [nl2br](https://twig.symfony.com/doc/2.x/filters/nl2br.html)
- [number_format](https://twig.symfony.com/doc/2.x/filters/number_format.html)
- [raw](https://twig.symfony.com/doc/2.x/filters/raw.html)
- [replace](https://twig.symfony.com/doc/2.x/filters/replace.html)
- [reverse](https://twig.symfony.com/doc/2.x/filters/reverse.html)
- [round](https://twig.symfony.com/doc/2.x/filters/round.html)
- [slice](https://twig.symfony.com/doc/2.x/filters/slice.html)
- [sort](https://twig.symfony.com/doc/2.x/filters/sort.html)
- [split](https://twig.symfony.com/doc/2.x/filters/split.html)
- [striptags](https://twig.symfony.com/doc/2.x/filters/striptags.html)
- [title](https://twig.symfony.com/doc/2.x/filters/title.html)
- [trim](https://twig.symfony.com/doc/2.x/filters/trim.html)
- [upper](https://twig.symfony.com/doc/2.x/filters/upper.html)
- [url_encode](https://twig.symfony.com/doc/2.x/filters/url_encode.html)

MeinCMS sudah mendaftarkan fungsi filter lain yang juga dapat dipakai di Twig, yang dapat dilihat di dalam file mein/application/config/twig.php. Kamu dapat menambahkan fungsi yang didukung di dalam file konfigurasi tersebut:

```php
$config['twig_filters'] = [
	'xss_clean',
];
```
