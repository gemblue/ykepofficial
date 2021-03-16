# Memuat File Asset dari Module

Karena module ada di luar folder public, maka kita gunakan teknik memuat isi file asset. Gunakan fungsi helper berikut untuk bekerja dengan file asset dari module:

### `module_asset_url($module, $file)`

Fungsi ini mengembalikan url asset dari modul.

`$module` adalah nama module yang ingin dipanggil assetnya
`$file` adalah nama file yang ingin dipanggil

Contoh:
```php
<link rel="stylesheet" href="<?= module_asset_url('files','style.css'); ?>" />
```

Kode di atas akan mencetak seperti ini:
```
<link rel="stylesheet" href="https://codepolitan.test/asset/module/files/style.css" />
```

Perhatikan bahwa struktur asset di modul mesti seperti berikut:
```
namamodule/
-- assets/
   -- css/
      -- style.css
      -- custom.css
   -- js/
      -- script.js
   -- img/
      -- thumb.jpg
```

Jika file asset selain js, css dan gambar, maka kamu boleh langsung pasang di bawah folder assets/ atau di subfolder lain dengan menyertakan pemanggilan subfolder pada namafile.

Contoh:
```php
<!-- Contoh file di root assets/ -->
<?php echo module_asset_url('files','db.xml'); ?>

<!-- Contoh file di subfolder assets/data/json/ -->
<?php echo module_asset_url('files','data/json/sidebar.json'); ?>
```
