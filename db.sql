-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `accesslog`;
CREATE TABLE `accesslog` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `object_type` varchar(20) NOT NULL,
  `object_id` int(11) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `referer_url` varchar(255) DEFAULT NULL,
  `access_type` enum('f','p','m') NOT NULL DEFAULT 'm' COMMENT 'f:free, p:paid, m:membership',
  `date_access` date NOT NULL,
  `viewed` tinyint(3) NOT NULL DEFAULT '1',
  `learned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` tinyint(1) NOT NULL DEFAULT '9',
  `type` varchar(45) NOT NULL,
  `payload` text COMMENT 'JSON payload',
  `response` text,
  `status` enum('queued','running','done') NOT NULL DEFAULT 'queued',
  `attempt` tinyint(1) DEFAULT '0',
  `run_time` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `mein_labels`;
CREATE TABLE `mein_labels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mein_navigations`;
CREATE TABLE `mein_navigations` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `url` text,
  `url_type` enum('uri','external') NOT NULL DEFAULT 'uri',
  `target` enum('_blank','_self','_top','_parent') DEFAULT '_self',
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `parent` int(11) DEFAULT NULL,
  `nav_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mein_navigation_areas`;
CREATE TABLE `mein_navigation_areas` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(100) NOT NULL,
  `area_slug` varchar(100) NOT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mein_options`;
CREATE TABLE `mein_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_group` varchar(30) DEFAULT 'site',
  `option_name` varchar(30) DEFAULT NULL,
  `option_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_options` (`id`, `option_group`, `option_name`, `option_value`) VALUES
(1714,	'theme',	'admin_logo_bg',	'333333'),
(1715,	'theme',	'navbar_color',	'FFFFFF'),
(1716,	'theme',	'navbar_text_color',	'425e4f'),
(1717,	'theme',	'link_color',	'E84A94'),
(1718,	'theme',	'btn_primary',	'007BFF'),
(1719,	'theme',	'btn_secondary',	'6C757D'),
(1720,	'theme',	'btn_success',	'28A745'),
(1721,	'theme',	'btn_info',	'138496'),
(1722,	'theme',	'btn_warning',	'E0A800'),
(1723,	'theme',	'btn_danger',	'DC3545'),
(1724,	'theme',	'admin_color',	'seagreen'),
(1725,	'theme',	'facebook_pixel_code',	''),
(1726,	'theme',	'gtag_id',	''),
(1727,	'site',	'site_title',	'Yayasan Eka Paksi'),
(1728,	'site',	'site_desc',	''),
(1729,	'site',	'site_logo',	''),
(1730,	'site',	'site_logo_small',	''),
(1731,	'site',	'phone',	'087778086140'),
(1732,	'site',	'email',	'hello@ykep.com'),
(1733,	'site',	'maps',	'<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7921.492039980645!2d107.586337!3d-6.920936!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb0b460bfaecab919!2sKimia%20Jaya!5e0!3m2!1sen!2sid!4v1615693883177!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),
(1734,	'site',	'ga',	'<script>\r\n(function(w,d,s,g,js,fjs){\r\n  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};\r\n  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];\r\n  js.src=\'https://apis.google.com/js/platform.js\';\r\n  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load(\'analytics\')};\r\n}(window,document,\'script\'));\r\n</script>'),
(1735,	'site',	'address',	''),
(1736,	'site',	'enable_registration',	'on'),
(1737,	'emailer',	'use_mailcatcher',	'yes'),
(1738,	'emailer',	'smtp_host',	'in-v3.mailjet.com'),
(1739,	'emailer',	'smtp_port',	'587'),
(1740,	'emailer',	'smtp_username',	'8443024b25c98692c6e2647372c7be5f'),
(1741,	'emailer',	'smtp_password',	''),
(1742,	'emailer',	'email_from',	'contact@kimiajaya.com'),
(1743,	'emailer',	'sender_name',	'Kimia Jaya'),
(1744,	'product',	'enable',	'off'),
(1745,	'product',	'remind_expired',	'3'),
(1746,	'post',	'posttype_config',	'page:\r\n    label: Pages\r\n    entry: mein_post_page\r\npdf:\r\n    label: PDF\r\n    entry: mein_post_pdf\r\nlink:\r\n    label: Link\r\n    entry: mein_post_link\r\n'),
(1747,	'dashboard',	'maintenance_mode',	'off'),
(1748,	'user',	'confirmation_type',	'link'),
(1749,	'user',	'use_single_login',	'yes'),
(1750,	'sample',	'enable',	'off'),
(1751,	'sample',	'title',	'');

DROP TABLE IF EXISTS `mein_posts`;
CREATE TABLE `mein_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `content_type` varchar(20) NOT NULL DEFAULT 'markdown',
  `intro` text,
  `featured` datetime DEFAULT NULL,
  `title` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `pdf` varchar(255) DEFAULT NULL,
  `redirect_link` varchar(255) DEFAULT NULL,
  `slug` varchar(200) NOT NULL DEFAULT '',
  `total_seen` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'post',
  `template` varchar(30) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `embed_video` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `featured` (`featured`,`status`,`type`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_posts` (`id`, `author`, `content`, `content_type`, `intro`, `featured`, `title`, `status`, `pdf`, `redirect_link`, `slug`, `total_seen`, `type`, `template`, `featured_image`, `embed_video`, `published_at`, `created_at`, `updated_at`) VALUES
(1,	1,	'**1. Test**',	'markdown',	NULL,	NULL,	'Sample Post',	'trash',	NULL,	NULL,	'sample-post',	1,	'post',	'default',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	'',	'2021-03-27 09:09:20',	'2021-03-14 09:42:12',	NULL),
(2,	1,	'Sample info',	'markdown',	NULL,	NULL,	'Sample Info',	'trash',	NULL,	NULL,	'sample-info',	0,	'post',	'default',	'https://i.ibb.co/RPg2gwC/kampus-unjani-cimahi.jpg',	'',	'2021-03-17 07:45:04',	'2021-03-17 07:44:36',	NULL),
(3,	1,	'\r\nWhat is Lorem Ipsum?\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nWhy do we use it?\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n',	'markdown',	NULL,	NULL,	'Sample berita',	'trash',	'',	'',	'sample-berita-1',	0,	'post',	'default',	'https://i.ibb.co/qRt2n7k/gambar-berita-4.jpg',	'',	'2021-03-17 07:45:24',	'2021-03-17 07:45:21',	NULL),
(4,	1,	'https://www.unjani.ac.id/2021/01/06/ykep-siapkan-universitas-jenderal-achmad-yani-menjadi-dapur-intelektual-tni-ad/',	'markdown',	NULL,	NULL,	'YKEP Siapkan Universitas Jenderal Achmad Yani Menjadi Dapur Intelektual TNI AD',	'publish',	'',	'https://www.unjani.ac.id/2021/01/06/ykep-siapkan-universitas-jenderal-achmad-yani-menjadi-dapur-intelektual-tni-ad/',	'ykep-siapkan-new-unjani',	3,	'post',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/logo-color.png',	'https://www.youtube.com/watch?v=zF9T_4nOTzw',	'2021-03-25 14:45:26',	'2021-03-25 14:45:03',	NULL),
(5,	1,	'\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"',	'markdown',	NULL,	NULL,	'Daftar BUMY',	'publish',	'https://drive.google.com/file/d/1BVdi24pUcOarUXfgHnoODo6NZRuD98Fw/preview',	'',	'beta-list-bumy',	2,	'post',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/icon_kegiatan_BUMY.png',	'https://file-examples-com.github.io/uploads/2017/10/file-example_PDF_500_kB.pdf',	'2021-03-26 13:42:42',	'2021-03-26 13:42:34',	NULL),
(6,	1,	'asd',	'markdown',	NULL,	NULL,	'asda',	'publish',	NULL,	NULL,	'asda',	0,	'page',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	'',	'2021-03-27 08:40:54',	'2021-03-27 08:30:39',	NULL),
(7,	1,	'1. * # *asdsa*[https://www.youtube.com/watch?v=FQPGvRZuDeg\r\n\r\n\r\n![](https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edithttp://)',	'markdown',	NULL,	'2021-03-27 09:09:02',	'test1',	'trash',	NULL,	NULL,	'test1',	0,	'post',	'default',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	'https://www.youtube.com/watch?v=FQPGvRZuDeg',	'2021-03-27 08:35:03',	'2021-03-27 08:34:59',	NULL),
(8,	1,	'Oke semua hebat',	'markdown',	NULL,	'2021-03-27 23:15:00',	'test berita',	'trash',	'https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edit',	'https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edit',	'test-berita',	0,	'post',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/Capture.PNG',	NULL,	'2021-03-27 23:13:52',	'2021-03-27 23:13:02',	NULL),
(9,	1,	'PMB Unjaya',	'markdown',	NULL,	NULL,	'Biaya Kuliah UNJAYA 2021',	'publish',	'',	'https://pmb.unjaya.ac.id/biaya-pendidikan',	'biaya-kuliah-unjaya-2021',	0,	'post',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/DSC_7596-480x300.jpg',	NULL,	'2021-03-28 11:55:04',	'2021-03-28 11:54:18',	NULL),
(10,	1,	'Contoh konten.',	'markdown',	NULL,	NULL,	'PDF Sample 1',	'trash',	'https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',	'',	'pdf-sample-1',	0,	'pdf',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',	NULL,	'2021-03-31 08:04:16',	'2021-03-31 08:00:57',	NULL),
(11,	1,	'Contoh konten.',	'markdown',	NULL,	NULL,	'Berita link 1',	'trash',	'https://files.com/sample.pdf',	'https://redirect.link',	'berita-link-1',	0,	'link',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',	NULL,	'2021-03-31 08:05:20',	'2021-03-31 08:05:13',	NULL),
(12,	1,	'test',	'markdown',	NULL,	NULL,	'Test 1',	'trash',	'',	'',	'test-2',	0,	'post',	'',	'https://ykep.cloudapp.web.id/uploads/original/1/0*71K8-aebabDwNzuX.jpg',	NULL,	'2021-03-31 17:30:38',	'2021-03-31 17:30:35',	NULL),
(13,	1,	'Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo menyambut kunjungan Ketua Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman beserta pengurus YKEP, di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20). \r\n\r\nKunjungan ini merupakan kunjungan perdana ketua beserta pengurus YKEP yang baru setelah dilantik Ketua Pembina YKEP, Jenderal TNI Andika Perkasa pada akhir September 2020.\r\n\r\nPada kesempatan itu, Djoko Susilo menyampaikan ucapan selamat datang kepada ketua dan para pengurus YKEP yang baru di Unjaya.\r\n\r\nIa juga menyampaikan progres perkembangan Unjaya yang merupakan hasil penggabungan dari Stikes dan Stmik Jenderal Achmad Yani Yogyakarta dan diresmikan pada 26 Maret 2018. \r\n\r\n“Beberapa capaian yang telah ditorehkan Unjaya dalam kurun waktu dua setengah tahun berdiri,” kata Djoko seperti dalam keterangan tertulisnya.\r\n\r\nAdapun capaian yang dimaksud, lanjut Djoko, antara lain telah terakreditasi Institusi dengan peringkat B, hampir keseluruhan Prodi juga telah berhasil menaikkan nilai akreditasinya menjadi B dan Baik.\r\n\r\n“Pada 2020 Unjaya juga sudah berhasil masuk dalam 4 klasterisasi perguruan tinggi yang dikeluarkan Kemendikbud,” kata Djoko.\r\n\r\nKetua Pengurus Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman saat mendengar penjelasan dari Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20).\r\nKetua Pengurus Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman saat mendengar penjelasan dari Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20). (Dok. Unjaya)\r\n\r\nPada pertemuan itu, Rektor Djoko menyampaikan puls berbagai tantangan untuk mengembangkan Unjaya, khususnya di era disruptif yang bersamaan dengan pandemi Covid-19.\r\n\r\nMenurutnya dalam menghadapu itu, Unjaya membutuhkan dukungan penuh dari YKEP selaku penyelenggara Unjaya. \r\n\r\nSementara itu, Ketua Pengurus YKEP menyampaikan bahwa ke depan bidang Pendidikan akan mendapatkan perhatian khusus dari YKEP.\r\n\r\nHal itu sesuai dengan visi YKEP di bidang pendidikan yang sudah dimulai dengan penambahan berbagai sarana prasarana di Lembaga Pendidikan (Lemdik) yang dimiliki YKEP. \r\n\r\nPada kesempatan itu, ketua dan para pengurus YKEP kemudian melakukan peninjauan berbagai fasilitas yang dimiliki Unjaya baik di Kampus 1 dan Kampus 2. \r\n\r\nMereka pun berdialog langsung dengan para dosen dan tenaga kependidikan untuk mendapatkan input dalam mengembangkan Unjaya agar semakin unggul dan terdepan.\r\n\r\nSumber : https://jogja.tribunnews.com/2020/11/06/rektor-unjaya-terima-kunjungan-ketua-dan-pengurus-ykep-yang-baru-ini-yang-dibahas',	'markdown',	NULL,	'2021-04-11 21:21:59',	'Rektor Unjaya Terima Kunjungan Ketua dan Pengurus YKEP yang Baru',	'publish',	'',	'',	'kunjungan-ykep1',	0,	'post',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/unnamed.png',	NULL,	'2021-03-31 18:06:48',	'2021-03-31 18:06:01',	NULL),
(14,	1,	'dsa',	'markdown',	NULL,	NULL,	'test 2',	'trash',	'https://ykep.cloudapp.web.id/uploads/original/1/Indri_Mustika_Putri.pdf',	'',	'test-3',	0,	'pdf',	'',	'https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',	NULL,	'2021-03-31 18:09:03',	'2021-03-31 18:08:59',	NULL),
(15,	1,	'asdsa',	'markdown',	NULL,	NULL,	'test link',	'trash',	'',	'https://www.unjani.ac.id/',	'test-link',	0,	'link',	'default',	'https://ykep.cloudapp.web.id/uploads/original/1/Capture.PNG',	NULL,	'2021-03-31 18:10:19',	'2021-03-31 18:10:17',	NULL),
(16,	1,	'test',	'markdown',	NULL,	NULL,	'Test',	'trash',	'',	'',	'test',	0,	'post',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-01 07:18:45',	'2021-04-01 07:17:40',	NULL),
(17,	4,	'test 1',	'markdown',	NULL,	NULL,	'test 1',	'trash',	'',	'',	'test00',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',	NULL,	'2021-04-12 08:33:38',	'2021-04-12 08:33:34',	NULL),
(18,	4,	'test pdf',	'markdown',	NULL,	NULL,	'test pdf',	'trash',	'https://drive.google.com/file/d/1tTX3K6MhJtrP3DfiFcVoPT7kkJctARer/view?usp=sharing',	'',	'test-pdf',	0,	'pdf',	'default',	'https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',	NULL,	'2021-04-12 08:39:18',	'2021-04-12 08:39:13',	NULL),
(19,	4,	'test ',	'markdown',	NULL,	NULL,	'test link',	'trash',	'',	'https://www.unjani.ac.id/',	'test-link1',	0,	'link',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-12 08:44:21',	'2021-04-12 08:44:18',	NULL),
(20,	4,	'test',	'markdown',	NULL,	NULL,	'PT Mrabantu baru',	'trash',	'',	'',	'pt-mrabantu-baru',	0,	'post',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-12 14:42:23',	'2021-04-12 14:42:20',	NULL),
(21,	12,	'https://www.dropbox.com/s/pifwnvaw14vqbu6/User%20Guide%20-%20%20Peserta%20PMB%20UNJANI.pdf?dl=0',	'markdown',	NULL,	NULL,	'PMB UNJANI CIMAHI',	'publish',	'',	'https://pendaftaran.unjani.ac.id/users/sign_in',	'pmb-unjani-cimahi',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/download.jpg',	NULL,	'2021-04-14 09:32:58',	'2021-04-14 09:32:52',	NULL),
(22,	12,	'https://pmb.unjaya.ac.id/',	'markdown',	NULL,	NULL,	'PMB UNJANI YOGYAKARTA',	'publish',	'',	'https://pmb.unjaya.ac.id/',	'pmb-unjani-yogyakarta',	1,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/UNJAYA.jpg',	NULL,	'2021-04-14 10:09:19',	'2021-04-14 10:09:04',	NULL),
(23,	12,	'Kepala Staf Angkatan Darat, Jenderal TNI Andika Perkasa melakukan kunjungan kerja ke Universitas Jenderal Achmad Yani (UNJANI) Cimahi, untuk melihat langsung kondisi UNJANI yang akan dilakukan perbaikan dan pembangunan ICT. ⁣⁣',	'markdown',	NULL,	NULL,	'Pembangunan ICT dan Fisik UNJANI Harus Selaras⁣⁣',	'trash',	'',	'https://tniad.mil.id/pembangunan-ict-fisik-unjani-harus-selaras%E2%81%A3%E2%81%A3/',	'pembangunan-ict-dan-fisik-unjani-harus-selaras',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/download_(4).jpg',	NULL,	'2021-04-14 11:06:10',	'2021-04-14 11:06:06',	NULL),
(24,	4,	'sadsa',	'markdown',	NULL,	NULL,	'test',	'trash',	'',	'',	'test_99',	0,	'post',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-26 17:05:01',	'2021-04-26 17:04:55',	NULL),
(25,	4,	'sadsa',	'markdown',	NULL,	NULL,	'test',	'trash',	'',	'',	'test_98',	0,	'pdf',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-26 17:06:52',	'2021-04-26 17:06:47',	NULL),
(26,	4,	'sadsa',	'markdown',	NULL,	NULL,	'test',	'trash',	'',	'',	'ii',	0,	'post',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-26 17:10:51',	'2021-04-26 17:10:45',	NULL),
(27,	4,	'dsadsad',	'markdown',	NULL,	NULL,	'oke',	'trash',	'',	'',	'oke',	0,	'link',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-26 17:13:08',	'2021-04-26 17:13:01',	NULL),
(28,	4,	'asdada',	'markdown',	NULL,	NULL,	'sdad',	'trash',	'',	'',	'sdad',	0,	'post',	'default',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-27 13:17:26',	'2021-04-27 13:17:23',	NULL),
(29,	4,	'asd',	'markdown',	NULL,	NULL,	'szdsa',	'trash',	'',	'https://www.unjani.ac.id/',	'szdsa',	0,	'post',	'',	'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',	NULL,	'2021-04-27 13:23:02',	'2021-04-27 13:22:59',	NULL),
(30,	12,	'Ketua Umum Yayasan Kartika Eka Paksi (YKEP) Letjen TNI (Purn) Tatang Sulaiman memaparkan visi dan misi YKEP dihadapan tim verifikasi dan evaluasi Ditjendikti Kemdikbud dan LLDIKTI Wilayah IV terkait akan dileburnya Sekolah Tinggi Ilmu Kesehatan Jenderal Achmad Yani (Stikes Jenderal A Yani) Cimahi kedalam Universitas Jenderal Achmad Yani Cimahi Kamis (22/04) lalu di aula Gedung Jenderal TNI Mulyono FISIP Universitas Jenderal Achmad Yani.',	'markdown',	NULL,	NULL,	'YKEP Lebur STIKES Jenderal Achmad Yani Kedalam Universitas Jenderal Achmad Yani',	'publish',	'',	'https://www.unjani.ac.id/2021/04/22/ykep-lebur-stikes-jenderal-achmad-yani-kedalam-universitas-jenderal-achmad-yani/',	'ykep-lebur-stikes-jenderal-achmad-yani-kedalam-universitas-jenderal-achmad-yani',	2,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/IMG_7774-1140x445.jpg',	NULL,	'2021-05-04 22:09:52',	'2021-05-04 22:09:46',	NULL),
(31,	12,	'(Humas Unjani) – Pada tanggal 06 Mei 2021 telah dilakasanakan kegiatan penyerahan beasiswa BNI bagi Mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani. Kegiatan dilaksanakan di Aula, Gedung TNI Mulyono FISIP Universitas Jenderal Achmad Yani.\r\nKegiatan di hadiri oleh Ketua Pengurus Yayasan Kartika Eka Paksi, Letjen TNI (Purn) Tatang Sulaiman, Rektor Universitas Jenderal Achmad Yani, Prof. Hikmahanto Juwana, SH., LL.M., Ph.D , Walikota Cimahi, Letkol Inf. (Purn) Ngatiyana, Wakil Pemimpin Wilayah BNI Kanwil Bandung, Wirawan A. Rachmana, dan Mahasiswi Kedokteran Gigi Universitas Jenderal Achmad Yani, Tesya Alifa Galtiady sebagai penerima beasiswa.\r\n\r\nKegiatan diawali dengan sambutan dari Wakil Pemimpin Wilayah BNI Kanwil Bandung, Wirawan A. Rachmana, ” Untuk itu sebagai bentuk kepedulian BNI terhadap pendidikan Indonesia, sejalan dengan program dari Universitas Jenderal Achmad Yani untuk mengembangkan sumber daya manusia dengan kualitas yang unggul agar mampu mengolah dan mengelola sda dan manusia , sehingga dapat digunakan untuk kesejahteraan masyarakat dan lingkungan sebagai akhir dari tujuan pembangunan itu sendiri. Maka hari ini BNI menyerahkan beasiswa penuh untuk mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani atas nama Tesya Alifa Galtiady.”\r\n\r\n“Atas nama keluarga BNI kami mengucapkan terimakasih kepada Bapak Ketua Yayasan Kartika Eka Paksi, Bapak Rektor UNJANI beserta seluruh pengurus Yayasan yang telah memberikan kepercayaan kepada BNI untuk dapat menjalin kerjasama dengan keluarga besar UNJANI atas kerjasama yang terjalin selama ini. Dengan harapan mudah mudahan kedepan kerjasama ini dapat terjalin lebih erat dan bisa saling memberikan manfaat.” tambah Wakil Pemimpin Wilayah BNI Kanwil Bandung\r\n\r\n“Saya mengatakan kepada teman teman kita harus mencari bibit bibit unggul di Cimahi untuk masuk di Fakultas Kedokteran dan Fakultas Kedokteran Gigi. Tahun kemarin kita melakukan proses seleksi bekerjasama dengan Dinas Pendidikan di Cimahi, sayangnya hanya\r\nmendapatkan 1 orang, yaitu adik Tesya Alifa. Kualifikasi menjadi mahasiswa di Fakultas Kedokteran dan Kedokteran Gigi ini sangat di tinggi dan ada beberapa test selain raport.” Ucap Rektor.\r\n\r\nRektor mengatakan terkait kerjasama beasiswa dengan BNI, “Kemudian BNI mengatakan bersedia untuk membiayai bagi adik kita untuk mendapatkan full scholarship. Saya berharap bahwa ini bukan yang pertama dan terakhir. Tetapi juga bisa diikuti dengan beasiswa beasiswa\r\nberikutnya, nanti juga saya akan mencoba ke BUMN BUMN lainnya untuk juga bisa meminta kepada mereka untuk membiayai putra putri Cimahi untuk sekolah di Fakultas Kedokteran dan Fakultas Kedokteran Gigi UNJANI.”. Mahasiswa yang mendapatkan beasiswa, setelah lulus harus mengabdi di Cimahi, karena itu tujuannya diberikan beasiswa.\r\n\r\nKemudian Ketua Yayasan Kartika Eka Paksi, Letjen TNI (Purn) Tatang Sulaiman memberikan sambutan, “BNI menjadi mitra yang terpilih. Ini mitra yang sudah terikat selama 15 tahun. Kita berharap mitra ini saling memberikan kontribusi yang banyak, salah satunya BNI lewat CSR nya memberikan beasiswa, bukan hanya UNJANI saja tetapi untuk masyarakat Cimahi dalam hal ini.”, ucap Ketua YKEP.\r\n\r\nWalikota Cimahi Letkol Inf. (Purn) Ngatiyana hadir dan memberikan sambutannya, “Alhamdulillah harus bersyukur kepada seluruh mahasiswa yang menerima beasiswa ini, gunakan kesempatan ini dengan sebaik baiknya, manfaatkan untuk menuntut ilmu ini sebaik\r\nbaiknya, sehingga tidak sia sia dalam menuntut ilmu sehingga Pendidikan dokter dapat diraih.” ucap Bapak Walikota.\r\n\r\n“Ini merupakan kebahagiaan bagi kita sendiri selaku pemerintah Kota Cimahi, mudah mudahan apa yang menjadi rencana kita khususnya akan membawa nama baik Kota Cimahi kami turut bangga bahwa Cimahi memiliki Universitas yang nantinya dapat diunggulkan di Kota Cimahi ini dan bersaing dengan universitas yang lain sehingga tidak mau kalah dengan Bandung bahwa Cimahi juga bisa lebih baik daripada yang lain. Kami harapkan mudah mudahan cepat pembangunannya di Kota Cimahi sehingga bisa dinikmati oleh masyarakat kota Cimahi.”\r\ntambah Bapak Walikota.\r\n\r\nAcara pun dilanjutkan dengan pemberian beasiswa kepada Tesya Alifa Galtiady kemudian dilaksanakan juga pemberian plakat kepada Ketua YKEP, Rektor UNJANI, dan Walikota Cimahi. Kegiatan pun berlangsung dengan lancar hingga selesai.',	'markdown',	NULL,	NULL,	'Penyerahan Beasiswa BNI Bagi Mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani',	'publish',	'https://www.unjani.ac.id/2021/05/06/penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani/',	'https://www.unjani.ac.id/2021/05/06/penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani/',	'penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/BEASISWA-BNI_mp4_snapshot_00_49_657-1140x445.jpg',	NULL,	'2021-06-07 08:59:46',	'2021-06-07 08:58:52',	NULL),
(32,	12,	'(Humas Unjani)-Dalam usaha akselerasi penerapan Information, Communication Technology (ICT) di New Univ. Jenderal A. Yani telah dilaksanakan pertemuan antara Yayasan Kartika Eka Paksi (YKEP), Univ. Jenderal A. Yani dan PT. Telkom Indonesia yang dilaksanakan pada tanggal 18-20 Mei 2021.\r\n\r\nDalam kegiatan Workshop ini, Univ. Jenderal A. Yani yang dipimpin oleh Wakil Rektor 3, dr. Dewi Ratih Handaryani, M.Kes didampingi oleh Ade Sena Permana ST, MT (Koordinator Pendampingan Pembangunan ICT Infrastruktur) dan Sigit Anggoro, ST, MT (Koordinator Penyelarasan Sinau dan Siterpadu) beserta anggota lainnya melakukan pendampingan ICT bersama PT. Telkom dihadapan YKEP.\r\n\r\nWorkshop ini dihadiri lebih kurang sekitar 50 peserta yang terdiri dari Tim YKEP, Univ. Jenderal A. Yani dan PT. Telkom Indonesia. Dalam workshop yang dilaksanakan 3 hari ini diterapkan protokol kesehatan yang ketat dimana seluruh peserta telah melakukan tes antigen dan selalu memakai masker selama melaksanakan kegiatan workshop.\r\n\r\nWorkshop ini membahas mengenai kerangka dari ICT Univ. Jenderal A. Yani dimana memotret sistem yang telah diterapkan saat ini dan menetapkan rencana pengembangan sistem yang akan diterapkan di Univ. Jenderal A. Yani yang akan menghasilkan Smart ICT. Workshop ICT dibagi menjadi 3 bidang, dimana terdiri dari bidang akademik, bidang sarana dan prasarana, serta bidang kemahasiswaan. Hal ini dilakukan agar setiap bidang memiliki ICT yang dapat memberikan nilai “Smart” sebagaimana harapan dari pengembangan ICT ini yang dapat mengedepankan kemudahan dari pengguna baik itu mahasiswa, dosen dan pengguna aplikasi lainnya.\r\n\r\nHasil dari Workshop ini kemudian akan menjadi acuan dalam percepatan implementasi ICT di New Univ. Jenderal A. Yani yang akan dilaporkan kepada KASAD dan Ketua YKEP.',	'markdown',	NULL,	NULL,	'Workshop Information, Communication Technologi (ICT) New Univ. Jenderal A. Yani',	'publish',	'https://www.unjani.ac.id/2021/05/20/workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani/',	'https://www.unjani.ac.id/2021/05/20/workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani/',	'workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/DSC02973-1140x445.jpg',	NULL,	'2021-06-07 09:11:08',	'2021-06-07 09:11:04',	NULL),
(33,	12,	'(Humas Unjani) – Universitas Jenderal Achmad Yani melakukan sosialisasi pendidikan pascasarjana di Akademi Militer, Magelang, Jawa Tengah pada hari Kamis (27/5/2021). Pada kegiatan ini, Universitas Jenderal Achmad Yani diketuai oleh Ketua BPH, Brigjen TNI (Purn.) Dr. Chairussani Abbas Sopamena, S.IP., M.Si. Lalu rombongan Universitas Jenderal Achmad Yani yaitu Wakil Rektor I, Dr. Agus Subagyo, S.IP., M.Si.; Wakil Rektor II, Dr. Asep Kurniawan, S.E., M.T., ASCA., CHRA.; KepalaBiro Akademik, Dr. Luqman Munawar Fauzi, S.IP., M.Si.; Kabag Coklitku, Yun Yun, S.E., M.S.M.; dan dosen Jurusan Ilmu Hubungan Internasional, Renaldo Benarrivo, S.IP., M.Hub.Int.\r\n\r\nMenurut Dr. Luqman Munawar Fauzi, S.IP., M.Si., kegiatan ke Akademi Militer bertujuan untuk proses pembukaan rangkaian kerjasama antara Universitas Jenderal Achmad Yani dengan Akademi Militer. “Kerjasama ini difokuskan pada trans-kerjasama bagi mereka, dengan harapan saat sekarang Taruna Tingkat IV atau Sermatutar itu bisa bergabung di Universitas Jenderal Achmad Yani tepatnya di beberapa Program Magister. Magister Ilmu Pemerintahan, Hubungan Internasional, Kimia, (Teknik) Sipil.”, tuturnya. Beliau juga melanjutkan, “Harapannya, begitu mereka tuntas menyelesaikan kegiatan pendidikan di Akmil, mereka bergabung bersama kita di Universitas Jenderal Achmad Yani untuk melanjutkan tingkat pendidikan S-2nya.”\r\n\r\nPihak Akademi Militer menyambut baik sosialisasi yang dilakukan oleh Universitas Jenderal Achmad Yani dan juga disambut dengan antusiasme tinggi. Rombongan diterima oleh Wakil Gubernur Akademi Militer, namun pada saat proses kegiatan, diterima oleh Dirdik Akademi Militer. “Beliau sangat antusias memberikan bekal kepada para Taruna untuk bisa menambah kompetensi secara keilmuan, terutama dalam bidang knowledge atau pengetahuan akademisi.”, tambah Luqman.\r\n\r\nTujuan kunjungan ke Akademi Militer juga sesuai dengan motto Universitas Jenderal Achmad Yani yaitu SMART MILITARY UNIVERSITY, dan keberadaan Universitas Jenderal Achmad Yani yang berada dibawah naungan Yayasan Kartika Eka Paksi dan TNI Angkatan Darat dapat memberikan nilai lebih bagi prajurit, khususnya keluarga besar TNI Angkatan Darat.\r\n\r\nKegiatan ini masih bersifat sosialisasi dan penyampaian informasi tentang pembukaan Program Magister Universitas Jenderal Achmad Yani. Kedepannya, diharapkan ada kerjasama untuk memperkuat program ini.',	'markdown',	NULL,	NULL,	'Akademi Militer Sambut Baik Sosialisasi Program Magister Universitas Jenderal Achmad Yani',	'publish',	'https://www.unjani.ac.id/2021/05/27/akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani/',	'https://www.unjani.ac.id/2021/05/27/akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani/',	'akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani',	0,	'post',	'default',	'https://admin.ykep.org/uploads/original/12/WhatsApp-Image-2021-06-10-at-09_36_34-1140x445_(1).jpeg',	NULL,	'2021-06-15 11:53:51',	'2021-06-15 11:52:51',	NULL);

DROP TABLE IF EXISTS `mein_roles`;
CREATE TABLE `mein_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_roles` (`id`, `role_name`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Super',	'active',	'2013-05-13 10:32:53',	NULL),
(2,	'Member',	'active',	'2013-05-13 10:32:53',	'2021-03-27 23:27:54'),
(3,	'Admin',	'active',	'2020-12-28 11:56:37',	NULL),
(4,	'Customer',	'inactive',	'2021-03-27 15:55:09',	'2021-03-27 23:26:44');

DROP TABLE IF EXISTS `mein_role_privileges`;
CREATE TABLE `mein_role_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `privilege` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_role_privileges` (`id`, `role_id`, `module`, `privilege`, `created_at`) VALUES
(1,	4,	'post',	'post',	NULL),
(2,	4,	'post',	'post/index/all/:any',	NULL),
(3,	4,	'post',	'post/index/trash',	NULL),
(4,	4,	'post',	'post/add',	NULL),
(5,	4,	'post',	'post/insert',	NULL),
(6,	4,	'post',	'post/edit/:num',	NULL),
(7,	4,	'post',	'post/update/:num',	NULL),
(8,	4,	'post',	'post/search',	NULL),
(9,	4,	'post',	'post/post/draft',	NULL),
(10,	4,	'post',	'post/publish',	NULL),
(11,	4,	'post',	'post/trash',	NULL),
(12,	4,	'post',	'post/restore',	NULL),
(13,	4,	'post',	'post/delete',	NULL),
(14,	4,	'post',	'post/category',	NULL),
(15,	4,	'post',	'post/category/add/:any',	NULL),
(16,	4,	'post',	'post/category/insert',	NULL),
(17,	4,	'post',	'post/category/edit/:num',	NULL),
(18,	4,	'post',	'post/category/update/:num',	NULL),
(19,	4,	'post',	'post/category/search',	NULL),
(20,	4,	'post',	'post/category/delete',	NULL),
(21,	4,	'post',	'post/tags',	NULL),
(22,	4,	'post',	'post/tags/add',	NULL),
(23,	4,	'post',	'post/tags/insert',	NULL),
(24,	4,	'post',	'post/tags/edit',	NULL),
(25,	4,	'post',	'post/tags/update',	NULL),
(26,	4,	'post',	'post/tags/search',	NULL),
(27,	4,	'post',	'post/tags/delete',	NULL),
(28,	4,	'post',	'settings',	NULL),
(29,	4,	'user',	'user',	NULL),
(30,	4,	'user',	'user/edit/:num',	NULL),
(31,	4,	'user',	'user/update',	NULL),
(32,	4,	'user',	'user/activate/:num',	NULL),
(33,	4,	'user',	'user/block/:num',	NULL),
(34,	4,	'user',	'user/search/:any',	NULL),
(35,	4,	'user',	'user/checkUser/:any',	NULL),
(36,	4,	'user',	'user/add',	NULL),
(37,	4,	'user',	'user/insert',	NULL),
(38,	4,	'user',	'user/delete/:num',	NULL),
(39,	4,	'user',	'user/purge/:num',	NULL),
(40,	4,	'user',	'user/role',	NULL),
(41,	4,	'user',	'user/role/add',	NULL),
(42,	4,	'user',	'user/role/edit/:num',	NULL),
(43,	4,	'user',	'user/role/insert',	NULL),
(44,	4,	'user',	'user/role/update/:num',	NULL),
(45,	4,	'user',	'user/role/delete/:num',	NULL),
(46,	4,	'user',	'user/role/privileges/:num',	NULL),
(47,	4,	'user',	'user/role/update_role_privileges',	NULL),
(48,	4,	'user_profile',	'entry/user_profile',	NULL),
(49,	4,	'user_profile',	'entry/user_profile/add',	NULL),
(50,	4,	'user_profile',	'entry/user_profile/insert',	NULL),
(51,	4,	'user_profile',	'entry/user_profile/edit/:num',	NULL),
(52,	4,	'user_profile',	'entry/user_profile/update/:num',	NULL),
(53,	4,	'user_profile',	'entry/user_profile/delete/:num',	NULL),
(54,	4,	'user_profile',	'entry/user_profile/export_csv',	NULL),
(55,	4,	'question',	'entry/question',	NULL),
(56,	4,	'question',	'entry/question/add',	NULL),
(57,	4,	'question',	'entry/question/insert',	NULL),
(58,	4,	'question',	'entry/question/edit/:num',	NULL),
(59,	4,	'question',	'entry/question/update/:num',	NULL),
(60,	4,	'question',	'entry/question/delete/:num',	NULL),
(61,	4,	'question',	'entry/question/export_csv',	NULL),
(110,	2,	'post',	'post',	NULL),
(111,	2,	'post',	'post/index/all/:any',	NULL),
(112,	2,	'post',	'post/index/trash',	NULL),
(113,	2,	'post',	'post/add',	NULL),
(114,	2,	'post',	'post/insert',	NULL),
(115,	2,	'post',	'post/edit/:num',	NULL),
(116,	2,	'post',	'post/update/:num',	NULL),
(117,	2,	'post',	'post/search',	NULL),
(118,	2,	'post',	'post/post/draft',	NULL),
(119,	2,	'post',	'post/publish',	NULL),
(120,	2,	'post',	'post/trash',	NULL),
(121,	2,	'post',	'post/restore',	NULL),
(122,	2,	'post',	'post/delete',	NULL),
(123,	2,	'post',	'post/category',	NULL),
(124,	2,	'post',	'post/category/add/:any',	NULL),
(125,	2,	'post',	'post/category/insert',	NULL),
(126,	2,	'post',	'post/category/edit/:num',	NULL),
(127,	2,	'post',	'post/category/update/:num',	NULL),
(128,	2,	'post',	'post/category/search',	NULL),
(129,	2,	'post',	'post/category/delete',	NULL),
(130,	2,	'post',	'post/tags',	NULL),
(131,	2,	'post',	'post/tags/add',	NULL),
(132,	2,	'post',	'post/tags/insert',	NULL),
(133,	2,	'post',	'post/tags/edit',	NULL),
(134,	2,	'post',	'post/tags/update',	NULL),
(135,	2,	'post',	'post/tags/search',	NULL),
(136,	2,	'post',	'post/tags/delete',	NULL),
(137,	2,	'post',	'settings',	NULL),
(138,	2,	'page',	'pages',	NULL),
(139,	2,	'page',	'pages/sync',	NULL),
(140,	2,	'page',	'pages/create',	NULL),
(141,	2,	'page',	'pages/edit',	NULL),
(142,	2,	'page',	'pages/delete',	NULL),
(143,	2,	'page',	'pages/builder',	NULL),
(144,	2,	'page',	'pages/builder/savePage',	NULL),
(145,	2,	'dashboard',	'dashboard',	NULL),
(146,	2,	'dashboard',	'dashboard/recent_login',	NULL),
(147,	2,	'dashboard',	'settings',	NULL),
(148,	2,	'files',	'files',	NULL),
(149,	2,	'video',	'entry/video',	NULL),
(150,	2,	'video',	'entry/video/add',	NULL),
(151,	2,	'video',	'entry/video/insert',	NULL),
(152,	2,	'video',	'entry/video/edit/:num',	NULL),
(153,	2,	'video',	'entry/video/update/:num',	NULL),
(154,	2,	'video',	'entry/video/delete/:num',	NULL),
(155,	2,	'video',	'entry/video/export_csv',	NULL);

DROP TABLE IF EXISTS `mein_terms`;
CREATE TABLE `mein_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_terms` (`term_id`, `name`, `slug`) VALUES
(1,	'Sosial & Agama',	'Sosial'),
(2,	'BUMY',	'kategori-1'),
(3,	'Pendidikan',	'kategori-2'),
(4,	'Mitra',	'mitra'),
(5,	'tag-tes',	'tag-tes'),
(7,	'Sample',	'sample'),
(10,	'test pdf kategori',	'test-pdf-categori'),
(11,	'test link pdf',	'test-link-pdf'),
(12,	'Unjani',	'unjani'),
(13,	'PT Marabunta',	'PT-Marabunta');

DROP TABLE IF EXISTS `mein_term_relationships`;
CREATE TABLE `mein_term_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_term_relationships` (`id`, `object_id`, `term_taxonomy_id`, `term_order`) VALUES
(9,	2,	2,	0),
(20,	7,	4,	0),
(21,	1,	1,	0),
(25,	8,	4,	0),
(31,	12,	1,	0),
(34,	3,	3,	0),
(36,	11,	11,	0),
(37,	11,	7,	0),
(40,	15,	11,	0),
(45,	9,	3,	0),
(48,	4,	3,	0),
(49,	4,	5,	0),
(50,	5,	4,	0),
(62,	16,	1,	0),
(65,	13,	3,	0),
(67,	10,	10,	0),
(70,	17,	12,	0),
(71,	19,	11,	0),
(72,	18,	10,	0),
(73,	20,	13,	0),
(75,	21,	3,	0),
(78,	22,	3,	0),
(80,	23,	3,	0),
(81,	28,	12,	0),
(82,	29,	12,	0),
(84,	30,	3,	0),
(87,	31,	12,	0),
(89,	32,	12,	0),
(91,	33,	12,	0);

DROP TABLE IF EXISTS `mein_term_taxonomy`;
CREATE TABLE `mein_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  KEY `term_id` (`term_id`,`taxonomy`,`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1,	1,	'post_category',	'',	0,	0),
(2,	2,	'post_category',	'',	0,	0),
(3,	3,	'post_category',	'',	0,	0),
(4,	4,	'post_category',	'',	0,	0),
(5,	5,	'tag',	'',	0,	0),
(7,	7,	'tag',	'',	0,	0),
(10,	10,	'pdf_category',	'',	0,	0),
(11,	11,	'link_category',	'',	0,	0),
(12,	12,	'post_category',	'',	0,	0),
(13,	13,	'post_category',	'',	0,	0);

DROP TABLE IF EXISTS `mein_users`;
CREATE TABLE `mein_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `source_id` varchar(64) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `referral_code` varchar(10) DEFAULT NULL,
  `referrer_id` int(11) DEFAULT NULL,
  `password` tinytext,
  `status` varchar(20) DEFAULT 'inactive',
  `role_id` int(11) DEFAULT '3',
  `token` varchar(150) DEFAULT NULL,
  `cdn_token` text,
  `mail_unsubscribe` tinyint(1) DEFAULT NULL,
  `mail_invalid` tinyint(1) DEFAULT NULL,
  `mail_bounce` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source_id` (`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_users` (`id`, `session_id`, `source_id`, `name`, `email`, `username`, `short_description`, `avatar`, `url`, `referral_code`, `referrer_id`, `password`, `status`, `role_id`, `token`, `cdn_token`, `mail_unsubscribe`, `mail_invalid`, `mail_bounce`, `last_login`, `created_at`, `updated_at`) VALUES
(1,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxIiwiZW1haWwiOiJhZG1pbkBhZG1pbi5jb20iLCJ1c2VybmFtZSI6ImFkbWluIiwiZnVsbG5hbWUiOiJBZG1pbmlzdHJhdG9yIiwicm9sZV9uYW1lIjoiU3VwZXIiLCJyb2xlX2lkIjoiMSIsInRpbWVzdGFtcCI6MTYyMDAyMjM2OH0.c3',	NULL,	'Administrator',	'admin@admin.com',	'admin',	'',	'',	'',	NULL,	NULL,	'$P$BCpsKfrGhWdgEjqiqdk9DORDVXhGm6/',	'active',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-04-14 13:48:46',	'2021-03-13 06:53:11',	NULL),
(4,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiI0IiwiZW1haWwiOiJjYWhheWFhcmlmaW5oYW5hZmlAZ21haWwuY29tIiwidXNlcm5hbWUiOiJjYWh5YSIsImZ1bGxuYW1lIjoiY2FoeWEiLCJyb2xlX25hbWUiOiJTdXBlciIsInJvbGVfaWQiOiIxIiwidGltZXN0YW1wIjoxNjIwOTQ2Mz',	NULL,	'cahya',	'cahayaarifinhanafi@gmail.com',	'cahya',	'',	'',	'',	NULL,	NULL,	'$P$BNqKtWU/rhF6KRDNzRr5OrEtPXwp6D/',	'active',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-04-26 16:36:12',	'2021-03-13 06:53:11',	NULL),
(11,	NULL,	NULL,	'Dany',	'dany@email.com',	'dany',	'',	'',	'TEST',	NULL,	NULL,	'$P$BeuCxDJqz5bf/9TMz1W5g6f3qHXUoz.',	'active',	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-03-31 08:32:35',	NULL),
(12,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxMiIsImVtYWlsIjoiZXJpQGdtYWlsLmNvbSIsInVzZXJuYW1lIjoiZXJpIiwiZnVsbG5hbWUiOiJFcmkiLCJyb2xlX25hbWUiOiJTdXBlciIsInJvbGVfaWQiOiIxIiwidGltZXN0YW1wIjoxNjIzNzM4OTgyfQ.cYVcCWjqTzxDQ24vCH6',	NULL,	'Eri',	'eri@gmail.com',	'eri',	'',	'',	'',	NULL,	NULL,	'$P$BNKMJYhPq1.Z4S6o9W2LTuqxJoiq1y/',	'active',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-06-15 10:01:52',	'2021-04-13 10:51:17',	NULL),
(13,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxMyIsImVtYWlsIjoicmlrc2FyaWZvaUBnbWFpbC5jb20iLCJ1c2VybmFtZSI6IlJpa3NhIiwiZnVsbG5hbWUiOiJSaWtzYSAiLCJyb2xlX25hbWUiOiJTdXBlciIsInJvbGVfaWQiOiIxIiwidGltZXN0YW1wIjoxNjIxNzMxNDU1fQ.bWh',	NULL,	'Riksa ',	'riksarifoi@gmail.com',	'Riksa',	'',	'',	'',	NULL,	NULL,	'$P$Bjt.wa99EK4omtae0dI5t2zl.VENfn.',	'active',	1,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-05-14 05:54:06',	'2021-04-27 13:12:04',	NULL);

DROP TABLE IF EXISTS `mein_user_profile`;
CREATE TABLE `mein_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `address` text,
  `birthday` date DEFAULT NULL,
  `interest` text,
  `experience` tinyint(4) DEFAULT NULL,
  `jobs` varchar(255) DEFAULT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `portfolio_link` text,
  `description` text,
  `newsletter` tinyint(1) DEFAULT '1',
  `ready_to_work` tinyint(1) DEFAULT '0',
  `latest_ip` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `gender` varchar(255) DEFAULT 'l',
  `status_marital` varchar(255) DEFAULT 'single',
  `record_log` varchar(255) DEFAULT '0',
  `akun_ig` varchar(255) DEFAULT NULL,
  `akun_tiktok` varchar(255) DEFAULT NULL,
  `hobi` varchar(255) DEFAULT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `pemilik_rekening` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mein_user_profile` (`id`, `user_id`, `phone`, `address`, `birthday`, `interest`, `experience`, `jobs`, `profession`, `city`, `portfolio_link`, `description`, `newsletter`, `ready_to_work`, `latest_ip`, `created_at`, `updated_at`, `gender`, `status_marital`, `record_log`, `akun_ig`, `akun_tiktok`, `hobi`, `nomor_rekening`, `bank`, `pemilik_rekening`, `deleted_at`) VALUES
(1,	1,	'08987654321',	'Jl. Cijeungjing Padalarang Bandung Barat',	'2021-03-28',	NULL,	NULL,	'',	NULL,	'',	NULL,	NULL,	1,	0,	NULL,	'2021-03-13 06:53:11',	'2021-03-28 08:39:29',	'l',	'single',	'0',	'',	'',	'',	'',	'',	'',	NULL),
(4,	4,	'(+62) 902 2563 6387',	'Dk. Gajah Mada No. 842, Mojokerto 80186, Maluku',	'2021-03-27',	NULL,	NULL,	'',	NULL,	'',	NULL,	NULL,	1,	0,	NULL,	'2021-03-13 06:53:11',	'2021-04-07 20:20:39',	'l',	'single',	'0',	'',	'',	'',	'',	'',	'',	NULL),
(11,	11,	NULL,	NULL,	'2021-04-01',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	0,	NULL,	'2021-04-01 07:25:37',	NULL,	'l',	'single',	'0',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(12,	12,	NULL,	NULL,	'2021-04-13',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	0,	NULL,	'2021-04-13 12:54:25',	NULL,	'l',	'single',	'0',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(13,	13,	NULL,	NULL,	'2021-05-14',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	0,	NULL,	'2021-05-14 05:52:35',	NULL,	'l',	'single',	'0',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `mein_variables`;
CREATE TABLE `mein_variables` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `variable` varchar(100) NOT NULL DEFAULT 'anonymous',
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `module` varchar(20) NOT NULL,
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `migrations` (`module`, `version`) VALUES
('CI_core',	1),
('course',	1),
('post',	1),
('certificate',	1),
('variable',	1),
('payment',	2),
('author',	1),
('navigation',	1),
('user',	1),
('product',	1),
('forum',	1),
('wallet',	2),
('lessonlog',	1),
('bot',	1),
('affiliate',	1),
('setting',	1),
('membership',	4);

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `photo` (`id`, `title`, `description`, `thumbnail`, `picture`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Nirmala Anugrah Sejahtera',	'Nirmala Anugrah Sejahtera',	'https://admin.ykep.org/uploads/original/4/pt_nirmala_anugerah_sejahtera.jpg',	'https://admin.ykep.org/uploads/original/4/pt_nirmala_anugerah_sejahtera.jpg',	'2021-03-31 07:44:37',	'2021-04-01 07:54:32',	NULL),
(3,	'Cluster Green Forest',	'Cluster Green Forest',	'https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',	'https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',	'2021-04-01 07:55:36',	NULL,	NULL),
(4,	'Graha Kartika Anugrah',	'Graha Kartika Anugrah',	'https://admin.ykep.org/uploads/original/4/pt_graha_kartika_anugerah.jpg',	'https://admin.ykep.org/uploads/original/4/pt_graha_kartika_anugerah.jpg',	'2021-04-01 07:56:30',	NULL,	NULL),
(5,	'Vaksinasi di Discovery Shopping Mall ( DSM).',	'Kegiatan persiapan vaksinasi ',	'https://admin.ykep.org/uploads/original/4/WhatsApp_Image_2021-04-06_at_14_53_06.jpeg',	'https://admin.ykep.org/uploads/original/4/WhatsApp_Image_2021-04-06_at_14_53_06.jpeg',	'2021-04-07 20:24:25',	'2021-04-07 20:27:31',	NULL),
(9,	'Kunjungan Kerja Ke Hotel Aston Kartika Grogol',	'Ketua Pengurus beserta jajaran mengunjungi hotel aston kartika grogol',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-12-09_at_07_50_15-min.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-12-09_at_07_50_15-min.jpeg',	'2021-05-04 22:32:18',	'2021-05-04 22:36:45',	NULL),
(10,	'Ketua Pengurus YKEP Menikmati pelayanan yang ada di Rumah Sakit Gigi dan Mulut Unjani Cimahi',	'Ketua Pengurus YKEP Menikmati pelayanan yang ada di Rumah Sakit Gigi dan Mulut Unjani Cimahi',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-05_at_15_54_06_(1)-min.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-05_at_15_54_06_(1)-min.jpeg',	'2021-05-04 22:40:05',	'2021-05-04 22:41:40',	NULL),
(11,	'Kunjungan Kerja Ketua Pengurus YKEP beserta jajaran ke Rumah Sakit Gigi dan Mulut Unjani Cimahi',	'Kunjungan Kerja Ketua Pengurus YKEP beserta jajaran ke Rumah Sakit Gigi dan Mulut Unjani Cimahi',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-05_at_15_54_10_(2)-min.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-05_at_15_54_10_(2)-min.jpeg',	'2021-05-04 22:43:46',	NULL,	NULL),
(12,	'Ketua Pengurus YKEP di dampingi oleh Kabid Usaha & Investasi Menyelenggarakan  Fit and proper Test seseorang dianggap layak dan patut untuk menduduki  jabatan Komisaris dan Direktur BUMY .',	'Ketua Pengurus YKEP di dampingi oleh Kabid Usaha & Investasi Menyelenggarakan  Fit and proper Test seseorang dianggap layak dan patut untuk menduduki  jabatan Komisaris dan Direktur BUMY.',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-13_at_18_33_03-min.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-13_at_18_33_03-min.jpeg',	'2021-05-04 22:52:03',	'2021-05-04 22:55:52',	NULL),
(13,	'Kunjungan Kerja Ketua Pengurus YKEP beserta jajaran ke Pembangunan Gedung Farmasi Unjani Cimahi',	'Kunjungan Kerja Ketua Pengurus YKEP beserta jajaran ke Pembangunan Gedung Farmasi Unjani Cimahi',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-23_at_09_05_40_(1)-min.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2021-01-23_at_09_05_40_(1)-min.jpeg',	'2021-05-04 22:54:46',	NULL,	NULL),
(14,	'Kunjungan Kerja Ketua Pengurus YKEP ke PT SMIP di Gresik',	'Ketua Pengurus  YKEP dan jajarannya melakukan kunjungan kerja di PT Sumber Mas Indah Plywood',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-11-27_at_14_29_58.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-11-27_at_14_29_58.jpeg',	'2021-05-31 08:43:52',	'2021-05-31 08:44:48',	NULL),
(15,	'Foto Bersama Kasad, Pengurus YKEP, BNI, PT. Telkom, PT. Wika dan Rektor Unjani Cimahi',	'Foto Bersama Kasad, Pengurus YKEP, BNI, PT. Telkom, PT. Wika dan Rektor Unjani Cimahi di mabesad',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-11-27_at_14_29_58.jpeg',	'https://admin.ykep.org/uploads/original/12/WhatsApp_Image_2020-11-27_at_14_29_58.jpeg',	'2021-06-07 09:58:41',	'2021-06-07 09:58:45',	NULL);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `product_image` varchar(255) NOT NULL DEFAULT 'http://via.placeholder.com/300x300',
  `product_slug` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `custom_landing_url` varchar(255) DEFAULT NULL,
  `product_desc` text,
  `product_type` varchar(20) NOT NULL DEFAULT 'default',
  `normal_price` bigint(20) DEFAULT NULL,
  `retail_price` bigint(20) NOT NULL DEFAULT '10',
  `count_expedition` tinyint(1) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `object_type` varchar(50) DEFAULT NULL,
  `custom_data` text,
  `publish` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `product_name`, `product_image`, `product_slug`, `custom_landing_url`, `product_desc`, `product_type`, `normal_price`, `retail_price`, `count_expedition`, `object_id`, `object_type`, `custom_data`, `publish`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2,	'Membership',	'https://via.placeholder.com/300x300',	'membership_48RaOkeY',	NULL,	'',	'membership',	0,	99000,	0,	NULL,	'membership',	'{\"durasi_akses\":\"99999\"}',	1,	1,	'2021-02-01 04:22:10',	NULL,	'2021-03-14 02:54:57'),
(3,	'Amphitol 55AB Cocamidopropyl Betaine Foam Booster Jerigen 5 KG',	'http://localhost/heroicbit/public/views/kimiajaya/assets/images/896568d7-a106-466b-9ded-8feee2b8ffa5.png.webp',	'amphitol-55ab-cocamidopropyl-betaine-foam-booster-jerigen-5-kg',	NULL,	'Berfungsi untuk mengentalkan dan menghasilkan busa / foam booster',	'default',	20000,	10000,	0,	NULL,	'default',	'[]',	1,	1,	'2021-03-14 02:12:37',	NULL,	NULL),
(4,	'Oxalic Acid Asam Oksalat 1 KG',	'http://localhost/heroicbit/public/views/kimiajaya/assets/images/ff0579d3-724e-4cb6-adbd-e02d6dfcf810.png.webp',	'oxalic-acid-asam-oksalat-1-kg',	NULL,	'Oxalic Acid digunakan dalam berbagai industri, seperti proses dan pembuatan textile, treatment permukaan logam, penyamakan kulit, dan lain-lain',	'default',	20000,	10000,	0,	NULL,	'default',	'[]',	1,	1,	'2021-03-14 02:13:28',	NULL,	NULL),
(5,	'Kaporit Bubuk 60% Chlorine Tjiwi 15 KG',	'http://localhost/heroicbit/public/views/kimiajaya/assets/images/e5250a34-57ff-4d0b-bba2-fd1d81b87d12.jpg.webp',	'kaporit-bubuk-60-chlorine-tjiwi-15-kg',	NULL,	'Kaporit Bubuk dapat digunakan untuk disinfektan pada air minum atau air kolam',	'default',	20000,	10000,	0,	NULL,	'default',	'[]',	1,	1,	'2021-03-14 02:14:04',	NULL,	NULL),
(6,	'Tepung Pati Kentang Potato Starch 1KG',	'http://localhost/heroicbit/public/views/kimiajaya/assets/images/ddff536f-96a5-46f4-88f6-be1ab1c17877.jpeg',	'tepung-pati-kentang-potato-starch-1kg',	NULL,	'Tepung pati kentang dapat digunakan untuk berbagai makanan seperti kue, roti dan bakso',	'default',	20000,	10000,	0,	NULL,	'default',	'[]',	1,	1,	'2021-03-14 02:14:39',	NULL,	NULL);

DROP TABLE IF EXISTS `product_content`;
CREATE TABLE `product_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `question_box`;
CREATE TABLE `question_box` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `category` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question_box` (`id`, `name`, `email`, `phone`, `status`, `category`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4,	'Ryan',	'ryan@gmail.com',	'0853784958736',	'pending',	'Umum',	'Testing Message',	'2021-03-31 11:23:35',	NULL,	NULL),
(5,	'Nama',	'nama@gmail.com',	'085746758869',	'pending',	'Kategori 1',	'Assalamualaikum',	'2021-03-31 11:58:13',	NULL,	NULL),
(7,	'caca',	'caca@gmail.com',	'787',	'pending',	'Lain-Lain',	'test',	'2021-04-12 07:48:37',	NULL,	NULL),
(8,	'cahaya',	'arifin@gmail.com',	'09864764',	'accepted',	'Prestasi',	'Saya juara lomba IT',	'2021-04-12 14:39:42',	'2021-04-12 14:40:04',	NULL),
(9,	'Hello',	'hello@mail.com',	'085123',	'pending',	'Lain-Lain',	'Hello disana',	'2021-05-30 16:59:02',	NULL,	NULL);

DROP TABLE IF EXISTS `question_category`;
CREATE TABLE `question_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question_category` (`id`, `category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4,	'Plagiasi',	'2021-04-01 06:50:56',	NULL,	NULL),
(5,	'Sara',	'2021-04-01 06:51:19',	NULL,	NULL),
(6,	'Salah Cetak',	'2021-04-01 06:51:34',	NULL,	NULL),
(7,	'Lain-Lain',	'2021-04-01 06:51:53',	'2021-04-12 07:47:11',	NULL),
(9,	'Prestasi',	'2021-04-12 14:38:55',	NULL,	NULL);

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sliders` (`id`, `title`, `identifier`, `picture`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5,	'Banner Utama',	'2',	'https://admin.ykep.org/uploads/original/13/02.jpg',	'2021-05-14 05:57:31',	NULL,	NULL),
(6,	'Universitas',	'3',	'https://admin.ykep.org/uploads/original/13/03.jpg',	'2021-05-14 05:58:14',	NULL,	NULL),
(7,	'New Unjani',	'4',	'https://admin.ykep.org/uploads/original/13/04.jpg',	'2021-05-14 05:58:43',	NULL,	NULL);

DROP TABLE IF EXISTS `testimonies`;
CREATE TABLE `testimonies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `content` text NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `youtube_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `video` (`id`, `title`, `description`, `cover`, `youtube_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'New Unjani',	'Contoh',	'https://admin.ykep.org/uploads/original/4/logo-color_(1).png',	'LvouKYstUQA',	'2021-03-27 22:46:48',	'2021-04-01 06:58:59',	NULL),
(2,	'Profil Unjaya',	'Profil Unjaya',	'https://admin.ykep.org/uploads/original/4/DSC_7596-480x300.jpg',	'5IqNfc7anYU',	'2021-03-31 07:46:06',	'2021-04-01 07:47:54',	NULL),
(4,	'Launching Smart Campus Universitas Jenderal Achmad Yani',	'Universitas Jenderal Achmad Yani Cimahi akan memasuki tahap pembangunan untuk menjadi Smart Digital Campus yang merupakan bentuk kerja sama dari Yayasan Kartika Eka Paksi, PT. Telkom Indonesia, PT. Wijaya Karya, serta PT. Bank Negara Indonesia.⁣\r\n⁣\r\nPeresmian pembangunan Smart Digital Campus dan penandatangan perjanjian kerja sama telah dilakukan pada 22 Desember 2020 di Markas Besar TNI Angkatan Darat, disaksikan secara virtual oleh jajaran TNI Angkatan Darat sebanyak 1.000 partisipan di seluruh Indonesia.⁣\r\n⁣\r\nKetua Pengurus Yayasan Kartika Eka Paksi, Letjen TNI (Purn.) Tatang Sulaiman mengatakan pada awal pensiunnya, ia dilibatkan dalam perencanaan membangun Universitas Jenderal Achmad Yani. Menurutnya YKEP hadir untuk membantu Kepala Staf Angkatan Darat untuk mewujudkan kesejahteraan dalam bidang Pendidikan, moral keagamaan, dan sosial kemanusiaan.⁣\r\n⁣\r\n“Bapak Kasad terima kasih dukungannya sehingga ini amanah yang besar untuk mewujudkan kampus yang kita inginkan,” ujar ketua YKEP.⁣\r\n⁣\r\nIa juga berharap pembangunan Universitas Jenderal Achmad Yani Cimahi menjadi Smart Digital Campus akan menghasilkan mahasiswa-mahasiwa yang unggul sehingga dapat dibina menjadi bagian dari TNI Angkatan Darat.⁣\r\n⁣\r\nSelain itu, Rektor Universitas Jenderal Achmad Yani Cimahi, Prof. Hikmahanto Juwana juga menyampaikan terima kasih kepada YKEP yang telah melihat Pendidikan sebagai hal utama. Dijelaskan olehnya, nantinya Universitas Jenderal Achmad Yani tidak hanya memberikan pelajaran di kampus namun secara virtual sehingga dapat diikuti di seluruh Indonesia bahkan mancanegara.⁣\r\n⁣\r\n“Ini juga membuka peluang bagi prajurit TNI AD di seluruh Indonesia untuk dapat mengenyam Pendidikan perguruan tinggi,” ujar Prof. Hikmahanto Juwana.⁣\r\n⁣\r\nDilanjutkan olehnya, Universitas Jenderal Achmad Yani Cimahi akan menjadi Hybrid University dengan mempertahankan kegiatan konvesional belajar mengajar, namun di saat yang bersamaan juga menjadi Open University yang memanfaatkan Information Communication Technology dukungan dari PT. Telkom Indonesia.⁣\r\n⁣\r\nDalam kesempatan itu, Direktur Utama PT. Telkom Indonesia, Ririek Ardiansyah berharap pembangunan Universitas Jenderal Achmad Yani dapat dimanfaatkan sebaik-baiknya sehingga dapat menjawab berbagai tantangan serta mewujudkan visi untuk menjadi universitas yang berjiwa kebangsaan serta berwawasan lingkungan.⁣\r\n⁣\r\nTidak hanya memberikan nilai berkaitan dengan akademik, Universitas Jenderal Achmad Yani Cimahi akan menanamkan kedisiplinan yang tinggi sehingga setiap mahasiswa  tidak hanya mendapatkan pendidikan keilmuan tetapi pembinaan dan pengasuhan seperti di lingkungan TNI Angkatan Darat.⁣\r\n⁣',	'https://admin.ykep.org/uploads/original/12/download_(1).jpg',	'fn4hLa1DaKA',	'2021-04-14 10:49:27',	'2021-04-14 10:55:47',	NULL),
(5,	'Penandatanganan MoU Terkait Pengelolaan Perumahan Prajurit TNI AD⁣',	'⁣Pelaksanaan penandatanganan Memorandum of Understanding (MOU) antara Yayasan Kartika Eka Paksi, Induk Koperasi TNI Angkatan Darat, PT. Wijaya Karya (Persero) Tbk serta PT. Bank Tabungan Negara (Persero) Tbk mengenai pengelolaan perumahan prajurit TNI Angkatan Darat yang dilaksanakan di Markas Besar TNI Angkatan Darat.⁣\r\n⁣\r\nPembangunan 30.000 unit perumahan akan direalisasikan dalam kurun waktu 3 sampai 5 tahun. Sebagai langkah pertama PT. Wika akan mengeksekusi The Riverpark Residence yang berada di Desa Sukasirna, Kecamatan Jonggol, Kabupaten Bogor, Jawa Barat sebanyak 404 unit.⁣\r\n⁣\r\n“Ini merupakan salah satu prototype sesuai dengan arahan bapak Kasad, semoga proyek ini dapat dilaksanakan dengan sebaik-baiknya di tahun depan. The Riverpark Residence akan dibangun diatas tanah seluas 13.5 Hektar dengan mengusung konsep Smart And Sustainable Living Area Within Green Environment,” ujar Direktur Operasional PT. Wika.⁣\r\n⁣\r\nBank Tabungan Negara akan bersinergi dengan YKEP, Inkopad dan PT. Wika untuk mewujudkan penyediaan rumah bagi patriot bangsa TNI Angkatan Darat dengan cepat, harga terjangkau dan memiliki kualitas yang baik sesuai dengan visi dari Kepala Staf Angkatan Darat.⁣\r\n⁣\r\n“Kami bersama dengan Wika, Inkopad dan YKEP akan berusaha untuk setiap tahunnya harus bisa menyediakan rumah sekurang kurangnya 10.000 Unit,” ungkap Dirut PT BTN.⁣\r\n⁣\r\nDengan pembangunan satu rumah yang akan selesai dalam waktu kurang dari dua minggu karena penggunaan teknologi terbaru yang dimiliki oleh PT. Wijaya Karya (Persero) Tbk. Jenderal TNI Andika Perkasa selaku Pembina Utama Yayasan Kartika Eka Paksi berharap seluruh pembangunan kawasan hunian yang diperuntukan bagi prajurit TNI Angkatan Darat akan berdampak pada peningkatan komitmen untuk mensejahterakan keluarga besar TNI AD.⁣',	'https://admin.ykep.org/uploads/original/12/download_(3).jpg',	'WS68WYQ3n84',	'2021-04-14 10:57:50',	'2021-04-14 10:58:50',	NULL),
(6,	'KASAD JENDERAL TNI ANDIKA PERKASA MENGUNJUNGI UNIVERSITAS JENDERAL ACHMAD YANI CIMAHI',	'Kepala Staf Angkatan Darat, Jenderal TNI Andika Perkasa melakukan kunjungan kerja ke Universitas Jenderal Achmad Yani (UNJANI) Cimahi, untuk melihat langsung kondisi UNJANI yang akan dilakukan perbaikan dan pembangunan ICT. ⁣\r\n⁣\r\nDalam sambutannya, Kasad memberikan semangat kepada para Civitas Academica UNJANI untuk membuat Universitas tersebut lebih maju dan berkembang ke level yang sangat tinggi. Untuk itu, salah satu langkah yang diambil yakni dengan membangun ICT yang pengerjaanya bekerja sama dengan Telkom.⁣\r\n⁣\r\n“Sebetulnya potensi sangat besar, karena kreatifitas di dunia pendidikan itu sudah sangat cepat. Makanya ICT ini kita bangun, supaya kita bisa menambah jumlah mahasiswa tanpa secara fisik berada sering disini,” ujar Kasad.⁣\r\n⁣\r\nSelain itu, Kasad juga memantau kondisi bangunan UNJANI yang perlu dilakukan pemugaran agar lebih menarik dan nyaman sebagai tempat menuntut ilmu. Salah satunya rencana pemugaran gapura UNJANI.⁣\r\n⁣\r\n“Inilah semangat yang harus kita pegang, kita boleh kecil, kita boleh di kampung, tapi buat orang look up ke kita,” imbuhnya.⁣\r\n⁣\r\nIa berharap keselarasan pembangunan ICT dan fisik UNJANI serta reputasi para Civitas Academica UNJANI, akan menjadikannya Universitas yang mampu bersaing dengan universitas lain yang sudah terkenal dan memiliki kredibilitas.⁣\r\n⁣\r\n“Dukung kita semua. dukung rektor baru, dukung ketua YKEP yang lama dan yang baru. Together We Can, bersama kita bisa,” tutupnya.⁣',	'https://admin.ykep.org/uploads/original/12/download_(5).jpg',	'iQIHK52O5Aw',	'2021-04-14 12:00:03',	'2021-05-04 22:20:07',	NULL),
(7,	'Kasad Memimpin Rapat Penyatuan Stikes Unjani ke Pihak Universitas Jenderal Achmad Yani⁣⁣',	'⁣⁣Kepala Staf Angkatan Darat, Jenderal TNI Andika Perkasa bersama Jajaran Petinggi TNI AD, mengadakan rapat dengan pengurus Yayasan Kartika Eka Paksi terkait penyatuan Sekolah Tinggi Ilmu Kesehatan (STIKES) Jenderal Achmad Yani yang sebelumnya berdiri sendiri, sekarang menjadi satu kesatuan dengan Universitas Jenderal Achmad Yani Cimahi.⁣⁣',	'https://admin.ykep.org/uploads/original/12/download1.jpg',	'8EsTBlVLNgU',	'2021-05-04 22:23:53',	'2021-05-04 22:24:50',	NULL);

-- 2021-08-13 03:31:58
