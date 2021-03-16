# Pendahuluan

MeinCMS menggunakan CodeIgniter Framework versi 3.1.9 dengan penambahan dan modifikasi beberapa bagian, diantaranya:

- HMVC (Hierarchical MVC) https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
- Lex Parser https://github.com/pyrocms/lex
- Twig Template Engine https://twig.symfony.com/doc/2.x
- Base Model https://github.com/avenirer/CodeIgniter-MY_Model
- Admin Template terintegrasi
- PHPASS https://asecuritysite.com/encryption/phpass

Berikut ini struktur folder dari MeinCMS:

```folder
project/
├── docs/
├── mein/
│   ├── application/
│   ├── modules/
│   ├── themes/
│   └── vendor/
├── modules/
├── themes/
├── resources/
├── index.php
├── .htaccess
├── composer.json
└── env.json
```

## Fitur

Beberapa fitur yang sudah tersedia di MeinCMS diantaranya:

- Page Management
- Blog Post
- Post Commments
- User Management
- Entry & CRUD Generator
- File Manager
- Navigation
- Widget
- Site Settings

## Development

Membuat fitur baru di MeinCMS relatif mudah bila kamu sudah pernah menggunakan Framework CodeIgniter. MeinCMS menggunakan pendekatan Hierarchical MVC atau HMVC dalam mengatur fiturnya. Artinya setiap fitur disimpan di dalam sebuah module yang di dalamnya terdapat controller, model dan view. Module disimpan di dalam folder modules/ dengan struktur seperti ini:

```folder
project/
└── modules/
	├── config/
	├── controllers/
	├── helpers/
	├── libraries/
	├── models/
	├── views/
	├── module.yml
	└── Shortcodes.php
```

Lebih detail terkait HMVC dapat dilihat di dalam dokumentasi berikut https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc