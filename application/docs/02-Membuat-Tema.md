# Membuat Tema

Tema disimpan di dalam folder themes/ dengan minimum struktur seperti berikut:

```folder
project/
└── themes/
	└── temasaya/
		├── layouts/
		│   └── basic.twig
		└── pages/
			└── home/
				├── content.html
				└── index.yml
		
```

Kamu juga dapat membuat struktur lengkap seperti ini:

```folder
project/
└── themes/
	└── temasaya/
		├── assets/
		├── layouts/
		│   └── basic.twig
		├── pages/
		│   ├── 404/
		│   │   ├── content.html
		│   │   └── index.yml
		│   └── home/
		│	   ├── content.html
		│	   └── index.yml
		├── partials/
		└── single.twig
```

## Membuat Halaman/Page

## Membuat Daftar Artikel