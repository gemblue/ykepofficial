-- MySQL dump 10.13  Distrib 5.7.42, for Linux (x86_64)
--
-- Host: localhost    Database: ykep
-- ------------------------------------------------------
-- Server version	5.7.42-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accesslog`
--

DROP TABLE IF EXISTS `accesslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesslog`
--

LOCK TABLES `accesslog` WRITE;
/*!40000 ALTER TABLE `accesslog` DISABLE KEYS */;
/*!40000 ALTER TABLE `accesslog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_labels`
--

DROP TABLE IF EXISTS `mein_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_labels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_labels`
--

LOCK TABLES `mein_labels` WRITE;
/*!40000 ALTER TABLE `mein_labels` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_navigation_areas`
--

DROP TABLE IF EXISTS `mein_navigation_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_navigation_areas`
--

LOCK TABLES `mein_navigation_areas` WRITE;
/*!40000 ALTER TABLE `mein_navigation_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_navigation_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_navigations`
--

DROP TABLE IF EXISTS `mein_navigations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_navigations`
--

LOCK TABLES `mein_navigations` WRITE;
/*!40000 ALTER TABLE `mein_navigations` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_navigations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_options`
--

DROP TABLE IF EXISTS `mein_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_group` varchar(30) DEFAULT 'site',
  `option_name` varchar(30) DEFAULT NULL,
  `option_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1752 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_options`
--

LOCK TABLES `mein_options` WRITE;
/*!40000 ALTER TABLE `mein_options` DISABLE KEYS */;
INSERT INTO `mein_options` VALUES (1714,'theme','admin_logo_bg','333333'),(1715,'theme','navbar_color','FFFFFF'),(1716,'theme','navbar_text_color','425e4f'),(1717,'theme','link_color','E84A94'),(1718,'theme','btn_primary','007BFF'),(1719,'theme','btn_secondary','6C757D'),(1720,'theme','btn_success','28A745'),(1721,'theme','btn_info','138496'),(1722,'theme','btn_warning','E0A800'),(1723,'theme','btn_danger','DC3545'),(1724,'theme','admin_color','seagreen'),(1725,'theme','facebook_pixel_code',''),(1726,'theme','gtag_id',''),(1727,'site','site_title','Yayasan Eka Paksi'),(1728,'site','site_desc',''),(1729,'site','site_logo',''),(1730,'site','site_logo_small',''),(1731,'site','phone','087778086140'),(1732,'site','email','hello@ykep.com'),(1733,'site','maps','<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7921.492039980645!2d107.586337!3d-6.920936!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb0b460bfaecab919!2sKimia%20Jaya!5e0!3m2!1sen!2sid!4v1615693883177!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),(1734,'site','ga','<script>\r\n(function(w,d,s,g,js,fjs){\r\n  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};\r\n  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];\r\n  js.src=\'https://apis.google.com/js/platform.js\';\r\n  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load(\'analytics\')};\r\n}(window,document,\'script\'));\r\n</script>'),(1735,'site','address',''),(1736,'site','enable_registration','on'),(1737,'emailer','use_mailcatcher','yes'),(1738,'emailer','smtp_host','in-v3.mailjet.com'),(1739,'emailer','smtp_port','587'),(1740,'emailer','smtp_username','8443024b25c98692c6e2647372c7be5f'),(1741,'emailer','smtp_password',''),(1742,'emailer','email_from','contact@kimiajaya.com'),(1743,'emailer','sender_name','Kimia Jaya'),(1744,'product','enable','off'),(1745,'product','remind_expired','3'),(1746,'post','posttype_config','page:\r\n    label: Pages\r\n    entry: mein_post_page\r\npdf:\r\n    label: PDF\r\n    entry: mein_post_pdf\r\nlink:\r\n    label: Link\r\n    entry: mein_post_link\r\n'),(1747,'dashboard','maintenance_mode','off'),(1748,'user','confirmation_type','link'),(1749,'user','use_single_login','yes'),(1750,'sample','enable','off'),(1751,'sample','title','');
/*!40000 ALTER TABLE `mein_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_posts`
--

DROP TABLE IF EXISTS `mein_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_posts`
--

LOCK TABLES `mein_posts` WRITE;
/*!40000 ALTER TABLE `mein_posts` DISABLE KEYS */;
INSERT INTO `mein_posts` VALUES (1,1,'**1. Test**','markdown',NULL,NULL,'Sample Post','trash',NULL,NULL,'sample-post',1,'post','default','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg','','2021-03-27 09:09:20','2021-03-14 09:42:12',NULL),(2,1,'Sample info','markdown',NULL,NULL,'Sample Info','trash',NULL,NULL,'sample-info',0,'post','default','https://i.ibb.co/RPg2gwC/kampus-unjani-cimahi.jpg','','2021-03-17 07:45:04','2021-03-17 07:44:36',NULL),(3,1,'\r\nWhat is Lorem Ipsum?\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nWhy do we use it?\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n','markdown',NULL,NULL,'Sample berita','trash','','','sample-berita-1',0,'post','default','https://i.ibb.co/qRt2n7k/gambar-berita-4.jpg','','2021-03-17 07:45:24','2021-03-17 07:45:21',NULL),(4,1,'https://www.unjani.ac.id/2021/01/06/ykep-siapkan-universitas-jenderal-achmad-yani-menjadi-dapur-intelektual-tni-ad/','markdown',NULL,NULL,'YKEP Siapkan Universitas Jenderal Achmad Yani Menjadi Dapur Intelektual TNI AD','trash','','https://www.unjani.ac.id/2021/01/06/ykep-siapkan-universitas-jenderal-achmad-yani-menjadi-dapur-intelektual-tni-ad/','ykep-siapkan-new-unjani',3,'post','default','https://ykep.cloudapp.web.id/uploads/original/1/logo-color.png','https://www.youtube.com/watch?v=zF9T_4nOTzw','2021-03-25 14:45:26','2021-03-25 14:45:03',NULL),(5,1,'\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"','markdown',NULL,NULL,'Daftar BUMY','trash','https://drive.google.com/file/d/1BVdi24pUcOarUXfgHnoODo6NZRuD98Fw/preview','','beta-list-bumy',2,'post','default','https://ykep.cloudapp.web.id/uploads/original/1/icon_kegiatan_BUMY.png','https://file-examples-com.github.io/uploads/2017/10/file-example_PDF_500_kB.pdf','2021-03-26 13:42:42','2021-03-26 13:42:34',NULL),(6,1,'asd','markdown',NULL,NULL,'asda','publish',NULL,NULL,'asda',0,'page','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg','','2021-03-27 08:40:54','2021-03-27 08:30:39',NULL),(7,1,'1. * # *asdsa*[https://www.youtube.com/watch?v=FQPGvRZuDeg\r\n\r\n\r\n![](https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edithttp://)','markdown',NULL,'2021-03-27 09:09:02','test1','trash',NULL,NULL,'test1',0,'post','default','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg','https://www.youtube.com/watch?v=FQPGvRZuDeg','2021-03-27 08:35:03','2021-03-27 08:34:59',NULL),(8,1,'Oke semua hebat','markdown',NULL,'2021-03-27 23:15:00','test berita','trash','https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edit','https://docs.google.com/document/d/1Jwpqm6CbgK9GZbuuzA8vDuSF2JIUk863CArML6r1dKc/edit','test-berita',0,'post','default','https://ykep.cloudapp.web.id/uploads/original/1/Capture.PNG',NULL,'2021-03-27 23:13:52','2021-03-27 23:13:02',NULL),(9,1,'PMB Unjaya','markdown',NULL,NULL,'Biaya Kuliah UNJAYA 2021','trash','','https://pmb.unjaya.ac.id/biaya-pendidikan','biaya-kuliah-unjaya-2021',0,'post','default','https://ykep.cloudapp.web.id/uploads/original/1/DSC_7596-480x300.jpg',NULL,'2021-03-28 11:55:04','2021-03-28 11:54:18',NULL),(10,1,'Contoh konten.','markdown',NULL,NULL,'PDF Sample 1','trash','https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG','','pdf-sample-1',0,'pdf','default','https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',NULL,'2021-03-31 08:04:16','2021-03-31 08:00:57',NULL),(11,1,'Contoh konten.','markdown',NULL,NULL,'Berita link 1','trash','https://files.com/sample.pdf','https://redirect.link','berita-link-1',0,'link','default','https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',NULL,'2021-03-31 08:05:20','2021-03-31 08:05:13',NULL),(12,1,'test','markdown',NULL,NULL,'Test 1','trash','','','test-2',0,'post','','https://ykep.cloudapp.web.id/uploads/original/1/0*71K8-aebabDwNzuX.jpg',NULL,'2021-03-31 17:30:38','2021-03-31 17:30:35',NULL),(13,1,'Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo menyambut kunjungan Ketua Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman beserta pengurus YKEP, di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20). \r\n\r\nKunjungan ini merupakan kunjungan perdana ketua beserta pengurus YKEP yang baru setelah dilantik Ketua Pembina YKEP, Jenderal TNI Andika Perkasa pada akhir September 2020.\r\n\r\nPada kesempatan itu, Djoko Susilo menyampaikan ucapan selamat datang kepada ketua dan para pengurus YKEP yang baru di Unjaya.\r\n\r\nIa juga menyampaikan progres perkembangan Unjaya yang merupakan hasil penggabungan dari Stikes dan Stmik Jenderal Achmad Yani Yogyakarta dan diresmikan pada 26 Maret 2018. \r\n\r\n“Beberapa capaian yang telah ditorehkan Unjaya dalam kurun waktu dua setengah tahun berdiri,” kata Djoko seperti dalam keterangan tertulisnya.\r\n\r\nAdapun capaian yang dimaksud, lanjut Djoko, antara lain telah terakreditasi Institusi dengan peringkat B, hampir keseluruhan Prodi juga telah berhasil menaikkan nilai akreditasinya menjadi B dan Baik.\r\n\r\n“Pada 2020 Unjaya juga sudah berhasil masuk dalam 4 klasterisasi perguruan tinggi yang dikeluarkan Kemendikbud,” kata Djoko.\r\n\r\nKetua Pengurus Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman saat mendengar penjelasan dari Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20).\r\nKetua Pengurus Yayasan Kartika Eka Paksi (YKEP), Letjen TNI (Purn) Tatang Sulaiman saat mendengar penjelasan dari Rektor Universitas Jenderal Achmad Yani Yogyakarta (Unjaya), Djoko Susilo di Ruang Rapat Pimpinan Kampus 1 Unjaya, Selasa (3/11/20). (Dok. Unjaya)\r\n\r\nPada pertemuan itu, Rektor Djoko menyampaikan puls berbagai tantangan untuk mengembangkan Unjaya, khususnya di era disruptif yang bersamaan dengan pandemi Covid-19.\r\n\r\nMenurutnya dalam menghadapu itu, Unjaya membutuhkan dukungan penuh dari YKEP selaku penyelenggara Unjaya. \r\n\r\nSementara itu, Ketua Pengurus YKEP menyampaikan bahwa ke depan bidang Pendidikan akan mendapatkan perhatian khusus dari YKEP.\r\n\r\nHal itu sesuai dengan visi YKEP di bidang pendidikan yang sudah dimulai dengan penambahan berbagai sarana prasarana di Lembaga Pendidikan (Lemdik) yang dimiliki YKEP. \r\n\r\nPada kesempatan itu, ketua dan para pengurus YKEP kemudian melakukan peninjauan berbagai fasilitas yang dimiliki Unjaya baik di Kampus 1 dan Kampus 2. \r\n\r\nMereka pun berdialog langsung dengan para dosen dan tenaga kependidikan untuk mendapatkan input dalam mengembangkan Unjaya agar semakin unggul dan terdepan.\r\n\r\nSumber : https://jogja.tribunnews.com/2020/11/06/rektor-unjaya-terima-kunjungan-ketua-dan-pengurus-ykep-yang-baru-ini-yang-dibahas','markdown',NULL,'2021-04-11 21:21:59','Rektor Unjaya Terima Kunjungan Ketua dan Pengurus YKEP yang Baru','trash','','','kunjungan-ykep1',0,'post','default','https://ykep.cloudapp.web.id/uploads/original/1/unnamed.png',NULL,'2021-03-31 18:06:48','2021-03-31 18:06:01',NULL),(14,1,'dsa','markdown',NULL,NULL,'test 2','trash','https://ykep.cloudapp.web.id/uploads/original/1/Indri_Mustika_Putri.pdf','','test-3',0,'pdf','','https://ykep.cloudapp.web.id/uploads/original/1/Contoh.PNG',NULL,'2021-03-31 18:09:03','2021-03-31 18:08:59',NULL),(15,1,'asdsa','markdown',NULL,NULL,'test link','trash','','https://www.unjani.ac.id/','test-link',0,'link','default','https://ykep.cloudapp.web.id/uploads/original/1/Capture.PNG',NULL,'2021-03-31 18:10:19','2021-03-31 18:10:17',NULL),(16,1,'test','markdown',NULL,NULL,'Test','trash','','','test',0,'post','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-01 07:18:45','2021-04-01 07:17:40',NULL),(17,4,'test 1','markdown',NULL,NULL,'test 1','trash','','','test00',0,'post','default','https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',NULL,'2021-04-12 08:33:38','2021-04-12 08:33:34',NULL),(18,4,'test pdf','markdown',NULL,NULL,'test pdf','trash','https://drive.google.com/file/d/1tTX3K6MhJtrP3DfiFcVoPT7kkJctARer/view?usp=sharing','','test-pdf',0,'pdf','default','https://admin.ykep.org/uploads/original/4/galeri_dokumentasi_2_cluster_green_forest.jpg',NULL,'2021-04-12 08:39:18','2021-04-12 08:39:13',NULL),(19,4,'test ','markdown',NULL,NULL,'test link','trash','','https://www.unjani.ac.id/','test-link1',0,'link','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-12 08:44:21','2021-04-12 08:44:18',NULL),(20,4,'test','markdown',NULL,NULL,'PT Mrabantu baru','trash','','','pt-mrabantu-baru',0,'post','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-12 14:42:23','2021-04-12 14:42:20',NULL),(21,12,'https://www.dropbox.com/s/pifwnvaw14vqbu6/User%20Guide%20-%20%20Peserta%20PMB%20UNJANI.pdf?dl=0','markdown',NULL,NULL,'PMB UNJANI CIMAHI','trash','','https://pmb.unjani.ac.id/','pmb-unjani-cimahi',1,'post','default','https://admin.ykep.org/uploads/original/12/download.jpg',NULL,'2021-04-14 09:32:58','2021-04-14 09:32:52',NULL),(22,12,'https://pmb.unjaya.ac.id/','markdown',NULL,NULL,'PMB UNJANI YOGYAKARTA','trash','','https://pmb.unjaya.ac.id/informasi-pendaftaran/','pmb-unjani-yogyakarta',3,'post','default','https://admin.ykep.org/uploads/original/12/UNJAYA.jpg',NULL,'2021-04-14 10:09:19','2021-04-14 10:09:04',NULL),(23,12,'Kepala Staf Angkatan Darat, Jenderal TNI Andika Perkasa melakukan kunjungan kerja ke Universitas Jenderal Achmad Yani (UNJANI) Cimahi, untuk melihat langsung kondisi UNJANI yang akan dilakukan perbaikan dan pembangunan ICT. ⁣⁣','markdown',NULL,NULL,'Pembangunan ICT dan Fisik UNJANI Harus Selaras⁣⁣','trash','','https://tniad.mil.id/pembangunan-ict-fisik-unjani-harus-selaras%E2%81%A3%E2%81%A3/','pembangunan-ict-dan-fisik-unjani-harus-selaras',0,'post','default','https://admin.ykep.org/uploads/original/12/download_(4).jpg',NULL,'2021-04-14 11:06:10','2021-04-14 11:06:06',NULL),(24,4,'sadsa','markdown',NULL,NULL,'test','trash','','','test_99',0,'post','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-26 17:05:01','2021-04-26 17:04:55',NULL),(25,4,'sadsa','markdown',NULL,NULL,'test','trash','','','test_98',0,'pdf','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-26 17:06:52','2021-04-26 17:06:47',NULL),(26,4,'sadsa','markdown',NULL,NULL,'test','trash','','','ii',0,'post','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-26 17:10:51','2021-04-26 17:10:45',NULL),(27,4,'dsadsad','markdown',NULL,NULL,'oke','trash','','','oke',0,'link','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-26 17:13:08','2021-04-26 17:13:01',NULL),(28,4,'asdada','markdown',NULL,NULL,'sdad','trash','','','sdad',0,'post','default','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-27 13:17:26','2021-04-27 13:17:23',NULL),(29,4,'asd','markdown',NULL,NULL,'szdsa','trash','','https://www.unjani.ac.id/','szdsa',0,'post','','http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg',NULL,'2021-04-27 13:23:02','2021-04-27 13:22:59',NULL),(30,12,'Ketua Umum Yayasan Kartika Eka Paksi (YKEP) Letjen TNI (Purn) Tatang Sulaiman memaparkan visi dan misi YKEP dihadapan tim verifikasi dan evaluasi Ditjendikti Kemdikbud dan LLDIKTI Wilayah IV terkait akan dileburnya Sekolah Tinggi Ilmu Kesehatan Jenderal Achmad Yani (Stikes Jenderal A Yani) Cimahi kedalam Universitas Jenderal Achmad Yani Cimahi Kamis (22/04) lalu di aula Gedung Jenderal TNI Mulyono FISIP Universitas Jenderal Achmad Yani.','markdown',NULL,NULL,'YKEP Lebur STIKES Jenderal Achmad Yani Kedalam Universitas Jenderal Achmad Yani','trash','','https://www.unjani.ac.id/2021/04/22/ykep-lebur-stikes-jenderal-achmad-yani-kedalam-universitas-jenderal-achmad-yani/','ykep-lebur-stikes-jenderal-achmad-yani-kedalam-universitas-jenderal-achmad-yani',2,'post','default','https://admin.ykep.org/uploads/original/12/IMG_7774-1140x445.jpg',NULL,'2021-05-04 22:09:52','2021-05-04 22:09:46',NULL),(31,12,'(Humas Unjani) – Pada tanggal 06 Mei 2021 telah dilakasanakan kegiatan penyerahan beasiswa BNI bagi Mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani. Kegiatan dilaksanakan di Aula, Gedung TNI Mulyono FISIP Universitas Jenderal Achmad Yani.\r\nKegiatan di hadiri oleh Ketua Pengurus Yayasan Kartika Eka Paksi, Letjen TNI (Purn) Tatang Sulaiman, Rektor Universitas Jenderal Achmad Yani, Prof. Hikmahanto Juwana, SH., LL.M., Ph.D , Walikota Cimahi, Letkol Inf. (Purn) Ngatiyana, Wakil Pemimpin Wilayah BNI Kanwil Bandung, Wirawan A. Rachmana, dan Mahasiswi Kedokteran Gigi Universitas Jenderal Achmad Yani, Tesya Alifa Galtiady sebagai penerima beasiswa.\r\n\r\nKegiatan diawali dengan sambutan dari Wakil Pemimpin Wilayah BNI Kanwil Bandung, Wirawan A. Rachmana, ” Untuk itu sebagai bentuk kepedulian BNI terhadap pendidikan Indonesia, sejalan dengan program dari Universitas Jenderal Achmad Yani untuk mengembangkan sumber daya manusia dengan kualitas yang unggul agar mampu mengolah dan mengelola sda dan manusia , sehingga dapat digunakan untuk kesejahteraan masyarakat dan lingkungan sebagai akhir dari tujuan pembangunan itu sendiri. Maka hari ini BNI menyerahkan beasiswa penuh untuk mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani atas nama Tesya Alifa Galtiady.”\r\n\r\n“Atas nama keluarga BNI kami mengucapkan terimakasih kepada Bapak Ketua Yayasan Kartika Eka Paksi, Bapak Rektor UNJANI beserta seluruh pengurus Yayasan yang telah memberikan kepercayaan kepada BNI untuk dapat menjalin kerjasama dengan keluarga besar UNJANI atas kerjasama yang terjalin selama ini. Dengan harapan mudah mudahan kedepan kerjasama ini dapat terjalin lebih erat dan bisa saling memberikan manfaat.” tambah Wakil Pemimpin Wilayah BNI Kanwil Bandung\r\n\r\n“Saya mengatakan kepada teman teman kita harus mencari bibit bibit unggul di Cimahi untuk masuk di Fakultas Kedokteran dan Fakultas Kedokteran Gigi. Tahun kemarin kita melakukan proses seleksi bekerjasama dengan Dinas Pendidikan di Cimahi, sayangnya hanya\r\nmendapatkan 1 orang, yaitu adik Tesya Alifa. Kualifikasi menjadi mahasiswa di Fakultas Kedokteran dan Kedokteran Gigi ini sangat di tinggi dan ada beberapa test selain raport.” Ucap Rektor.\r\n\r\nRektor mengatakan terkait kerjasama beasiswa dengan BNI, “Kemudian BNI mengatakan bersedia untuk membiayai bagi adik kita untuk mendapatkan full scholarship. Saya berharap bahwa ini bukan yang pertama dan terakhir. Tetapi juga bisa diikuti dengan beasiswa beasiswa\r\nberikutnya, nanti juga saya akan mencoba ke BUMN BUMN lainnya untuk juga bisa meminta kepada mereka untuk membiayai putra putri Cimahi untuk sekolah di Fakultas Kedokteran dan Fakultas Kedokteran Gigi UNJANI.”. Mahasiswa yang mendapatkan beasiswa, setelah lulus harus mengabdi di Cimahi, karena itu tujuannya diberikan beasiswa.\r\n\r\nKemudian Ketua Yayasan Kartika Eka Paksi, Letjen TNI (Purn) Tatang Sulaiman memberikan sambutan, “BNI menjadi mitra yang terpilih. Ini mitra yang sudah terikat selama 15 tahun. Kita berharap mitra ini saling memberikan kontribusi yang banyak, salah satunya BNI lewat CSR nya memberikan beasiswa, bukan hanya UNJANI saja tetapi untuk masyarakat Cimahi dalam hal ini.”, ucap Ketua YKEP.\r\n\r\nWalikota Cimahi Letkol Inf. (Purn) Ngatiyana hadir dan memberikan sambutannya, “Alhamdulillah harus bersyukur kepada seluruh mahasiswa yang menerima beasiswa ini, gunakan kesempatan ini dengan sebaik baiknya, manfaatkan untuk menuntut ilmu ini sebaik\r\nbaiknya, sehingga tidak sia sia dalam menuntut ilmu sehingga Pendidikan dokter dapat diraih.” ucap Bapak Walikota.\r\n\r\n“Ini merupakan kebahagiaan bagi kita sendiri selaku pemerintah Kota Cimahi, mudah mudahan apa yang menjadi rencana kita khususnya akan membawa nama baik Kota Cimahi kami turut bangga bahwa Cimahi memiliki Universitas yang nantinya dapat diunggulkan di Kota Cimahi ini dan bersaing dengan universitas yang lain sehingga tidak mau kalah dengan Bandung bahwa Cimahi juga bisa lebih baik daripada yang lain. Kami harapkan mudah mudahan cepat pembangunannya di Kota Cimahi sehingga bisa dinikmati oleh masyarakat kota Cimahi.”\r\ntambah Bapak Walikota.\r\n\r\nAcara pun dilanjutkan dengan pemberian beasiswa kepada Tesya Alifa Galtiady kemudian dilaksanakan juga pemberian plakat kepada Ketua YKEP, Rektor UNJANI, dan Walikota Cimahi. Kegiatan pun berlangsung dengan lancar hingga selesai.','markdown',NULL,NULL,'Penyerahan Beasiswa BNI Bagi Mahasiswa Fakultas Kedokteran Gigi Universitas Jenderal Achmad Yani','trash','https://www.unjani.ac.id/2021/05/06/penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani/','https://www.unjani.ac.id/2021/05/06/penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani/','penyerahan-beasiswa-bni-bagi-mahasiswa-fakultas-kedokteran-gigi-universitas-jenderal-achmad-yani',0,'post','default','https://admin.ykep.org/uploads/original/12/BEASISWA-BNI_mp4_snapshot_00_49_657-1140x445.jpg',NULL,'2021-06-07 08:59:46','2021-06-07 08:58:52',NULL),(32,12,'(Humas Unjani)-Dalam usaha akselerasi penerapan Information, Communication Technology (ICT) di New Univ. Jenderal A. Yani telah dilaksanakan pertemuan antara Yayasan Kartika Eka Paksi (YKEP), Univ. Jenderal A. Yani dan PT. Telkom Indonesia yang dilaksanakan pada tanggal 18-20 Mei 2021.\r\n\r\nDalam kegiatan Workshop ini, Univ. Jenderal A. Yani yang dipimpin oleh Wakil Rektor 3, dr. Dewi Ratih Handaryani, M.Kes didampingi oleh Ade Sena Permana ST, MT (Koordinator Pendampingan Pembangunan ICT Infrastruktur) dan Sigit Anggoro, ST, MT (Koordinator Penyelarasan Sinau dan Siterpadu) beserta anggota lainnya melakukan pendampingan ICT bersama PT. Telkom dihadapan YKEP.\r\n\r\nWorkshop ini dihadiri lebih kurang sekitar 50 peserta yang terdiri dari Tim YKEP, Univ. Jenderal A. Yani dan PT. Telkom Indonesia. Dalam workshop yang dilaksanakan 3 hari ini diterapkan protokol kesehatan yang ketat dimana seluruh peserta telah melakukan tes antigen dan selalu memakai masker selama melaksanakan kegiatan workshop.\r\n\r\nWorkshop ini membahas mengenai kerangka dari ICT Univ. Jenderal A. Yani dimana memotret sistem yang telah diterapkan saat ini dan menetapkan rencana pengembangan sistem yang akan diterapkan di Univ. Jenderal A. Yani yang akan menghasilkan Smart ICT. Workshop ICT dibagi menjadi 3 bidang, dimana terdiri dari bidang akademik, bidang sarana dan prasarana, serta bidang kemahasiswaan. Hal ini dilakukan agar setiap bidang memiliki ICT yang dapat memberikan nilai “Smart” sebagaimana harapan dari pengembangan ICT ini yang dapat mengedepankan kemudahan dari pengguna baik itu mahasiswa, dosen dan pengguna aplikasi lainnya.\r\n\r\nHasil dari Workshop ini kemudian akan menjadi acuan dalam percepatan implementasi ICT di New Univ. Jenderal A. Yani yang akan dilaporkan kepada KASAD dan Ketua YKEP.','markdown',NULL,NULL,'Workshop Information, Communication Technologi (ICT) New Univ. Jenderal A. Yani','trash','https://www.unjani.ac.id/2021/05/20/workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani/','https://www.unjani.ac.id/2021/05/20/workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani/','workshop-information-communication-technologi-ict-new-univ-jenderal-a-yani',0,'post','default','https://admin.ykep.org/uploads/original/12/DSC02973-1140x445.jpg',NULL,'2021-06-07 09:11:08','2021-06-07 09:11:04',NULL),(33,12,'(Humas Unjani) – Universitas Jenderal Achmad Yani melakukan sosialisasi pendidikan pascasarjana di Akademi Militer, Magelang, Jawa Tengah pada hari Kamis (27/5/2021). Pada kegiatan ini, Universitas Jenderal Achmad Yani diketuai oleh Ketua BPH, Brigjen TNI (Purn.) Dr. Chairussani Abbas Sopamena, S.IP., M.Si. Lalu rombongan Universitas Jenderal Achmad Yani yaitu Wakil Rektor I, Dr. Agus Subagyo, S.IP., M.Si.; Wakil Rektor II, Dr. Asep Kurniawan, S.E., M.T., ASCA., CHRA.; KepalaBiro Akademik, Dr. Luqman Munawar Fauzi, S.IP., M.Si.; Kabag Coklitku, Yun Yun, S.E., M.S.M.; dan dosen Jurusan Ilmu Hubungan Internasional, Renaldo Benarrivo, S.IP., M.Hub.Int.\r\n\r\nMenurut Dr. Luqman Munawar Fauzi, S.IP., M.Si., kegiatan ke Akademi Militer bertujuan untuk proses pembukaan rangkaian kerjasama antara Universitas Jenderal Achmad Yani dengan Akademi Militer. “Kerjasama ini difokuskan pada trans-kerjasama bagi mereka, dengan harapan saat sekarang Taruna Tingkat IV atau Sermatutar itu bisa bergabung di Universitas Jenderal Achmad Yani tepatnya di beberapa Program Magister. Magister Ilmu Pemerintahan, Hubungan Internasional, Kimia, (Teknik) Sipil.”, tuturnya. Beliau juga melanjutkan, “Harapannya, begitu mereka tuntas menyelesaikan kegiatan pendidikan di Akmil, mereka bergabung bersama kita di Universitas Jenderal Achmad Yani untuk melanjutkan tingkat pendidikan S-2nya.”\r\n\r\nPihak Akademi Militer menyambut baik sosialisasi yang dilakukan oleh Universitas Jenderal Achmad Yani dan juga disambut dengan antusiasme tinggi. Rombongan diterima oleh Wakil Gubernur Akademi Militer, namun pada saat proses kegiatan, diterima oleh Dirdik Akademi Militer. “Beliau sangat antusias memberikan bekal kepada para Taruna untuk bisa menambah kompetensi secara keilmuan, terutama dalam bidang knowledge atau pengetahuan akademisi.”, tambah Luqman.\r\n\r\nTujuan kunjungan ke Akademi Militer juga sesuai dengan motto Universitas Jenderal Achmad Yani yaitu SMART MILITARY UNIVERSITY, dan keberadaan Universitas Jenderal Achmad Yani yang berada dibawah naungan Yayasan Kartika Eka Paksi dan TNI Angkatan Darat dapat memberikan nilai lebih bagi prajurit, khususnya keluarga besar TNI Angkatan Darat.\r\n\r\nKegiatan ini masih bersifat sosialisasi dan penyampaian informasi tentang pembukaan Program Magister Universitas Jenderal Achmad Yani. Kedepannya, diharapkan ada kerjasama untuk memperkuat program ini.','markdown',NULL,NULL,'Akademi Militer Sambut Baik Sosialisasi Program Magister Universitas Jenderal Achmad Yani','trash','https://www.unjani.ac.id/2021/05/27/akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani/','https://www.unjani.ac.id/2021/05/27/akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani/','akademi-militer-sambut-baik-sosialisasi-program-magister-universitas-jenderal-achmad-yani',1,'post','default','https://admin.ykep.org/uploads/original/12/WhatsApp-Image-2021-06-10-at-09_36_34-1140x445_(1).jpeg',NULL,'2021-06-15 11:53:51','2021-06-15 11:52:51',NULL),(34,12,'INFORMASI PENDAFTARAN UNJAYA TAHUN 2023','markdown',NULL,NULL,'INFORMASI PENDAFTARAN UNJAYA TAHUN 2023','trash','https://pmb.unjaya.ac.id/informasi-pendaftaran/','https://pmb.unjaya.ac.id/informasi-pendaftaran/','informasi-pendaftaran-unjaya-tahun-2023',0,'post','default','https://admin.ykep.org/uploads/original/12/unnamed.jpg',NULL,'2023-05-28 22:20:55','2023-05-28 22:20:51',NULL),(35,12,'Informasi Fasilitas KBAD dan KBU\r\nPendaftar yang berasal dari KBAD/KBU dapat mengikuti program penerimaan Mahasiswa Baru (PMB) UNIVERSITAS JENDERAL ACHMAD YANI melalui jalur PMDK, Jalur Undangan, Jalur Prestasi atau Jalur USM. Definisi KBAD adalah anak/istri/suami yang sah dari anggota TNI-AD atau Pegawai Negeri Sipil TNI-AD baik yang masih aktif maupun sudah pensiun. Definisi KBU adalah anak/istri/suami yang sah dari pegawai Universitas Jenderal Achmad Yani yang masih aktif maupun yang sudah pensiun.\r\n\r\nFasilitas untuk KBAD/KBU :\r\na. Bebas biaya Pendaftaran untuk semua jalur masuk\r\nb. Mendapat potongan 20% Biaya Penyelenggaraan Pendidikan (BPP)\r\nper semester selama mengikuti kuliah di UNIVERSITAS JENDERAL\r\nACHMAD YANI berlaku mulai semester 2','markdown',NULL,NULL,'INFORMASI PMB UNJANI CIMAHI ','publish','https://pmb.unjani.ac.id/','https://pmb.unjani.ac.id/','informasi-pmb-unjani-cimahi',2,'post','default','https://admin.ykep.org/uploads/original/12/Screenshot_8.png',NULL,'2023-06-07 13:15:58','2023-06-07 13:15:54',NULL),(36,12,'Seleksi Penelusuran Minat dan Kemampuan (PMDK) atau Jalur Prestasi adalah jalur seleksi penerimaan calon mahasiswa melalui seleksi prestasi bidang akademik (rapor dan nilai UN), olahraga dan seni, dan atau undangan Institusi.\r\nBEBAS TEST, PMDK memungkinkan calon mahasiswa diterima tanpa mengikuti tes akademik.\r\nMENDAPATKAN POTONGAN BIAYA DI SEMESTER 1 dengan ketentuan yang ditetapkan oleh Pimpinan UNJAYA.\r\nBerlaku di semua Gelombang, dengan opsi ditutup sewaktu-waktu untuk Prodi tertentu jika kuota terpenuhi','markdown',NULL,NULL,'INFORMASI PMB UNJAYA','publish','https://pmb.unjaya.ac.id/','https://pmb.unjaya.ac.id/','informasi-pmb-unjaya',0,'post','default','https://admin.ykep.org/uploads/original/12/unnamed.jpg',NULL,'2023-07-13 12:08:59','2023-07-13 12:08:49',NULL),(37,12,'Universitas Jenderal Achmad Yani Yogyakarta merupakan Lembaga Pendidikan di bawah naungan Yayasan Kartika Eka Paksi (YKEP) hasil penggabungan Sekolah Tinggi Imu Kesehatan (Stikes) dan Sekolah Tinggi Manajemen Informatika dan Komputer (Stmik) Jenderal Achmad Yani Yogyakarta berdasarkan Surat Keputusan Kementerian Riset dan Teknologi Pendidikan Tinggi Nomor 166/KPP/I/2018 tanggal 2 Februari 2018 dan diresmikan oleh Kepala Staf TNI Angkatan Darat (Kasad) Jenderal TNI Mulyono pada 26 Maret 2018. Dengan berprinsip pada “Kampus Kejuangan” dan seiring dengan visi YKEP di bidang pendidikan yaitu “Tersedianya Lembaga Pendidikan Yang Mandiri, Terpercaya, Memiliki Keunggulan Kompetitif dan Menerapkan Tata Kelola Yang Baik Serta Mewarisi Jiwa/Semangat Kejuangan Jenderal Achmad Yani”, Universitas Jenderal Achmad Yani Yogyakarta memiliki dua kampus yaitu. Kampus 1 yang berlokasi di Jl. Siliwangi, Ringroad Barat, Banyuraden, sedangkan Kampus 2 berlokasi di Jl. Brawijaya, Ringroad Barat, Ambarketawang dimana keduanya berada di Kecamatan Gamping, Kabupaten Sleman, Daerah Istimewa Yogyakarta yang dilengkapi dengan ruang kuliah yang representatif, laboratorium berstandar internasional, dan didukung berbagai fasilitas penunjang pendidikan diantaranya: laboratorium komputer, laboratorium CBT, asrama mahasiswi, masjid, area olah raga, hotspot area, dan berbagai kerjasama baik dalam dan luar Negeri untuk mendukung pengembangan Akademik, penelitian dan praktik mahasiswa. Program Studi di Universitas Jenderal Achmad Yani Yogyakarta telah terakreditasi Lembaga Akreditasi Mandiri Pendidikan Tinggi Kesehatan Indonesia (LAM-PTKes) dan Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT), dimana untuk Insitusi telah terakreditasi dengan peringkat B berdasarkan SK BAN-PT Nomor: 394/SK/BAN-PT/Ak-PNB/PT/IX/2019.','markdown',NULL,NULL,'Profil Universitas Jenderal Achmad Yani Yogyakarta','publish','http://unjaya.ac.id/profil-universitas-jenderal-achmad-yani-yogyakarta/','http://unjaya.ac.id/profil-universitas-jenderal-achmad-yani-yogyakarta/','profil-universitas-jenderal-achmad-yani-yogyakarta',0,'post','','https://admin.ykep.org/uploads/original/12/unnamed.jpg',NULL,'2023-07-13 12:11:18','2023-07-13 12:11:16',NULL),(38,12,'SLEMAN – Bertempat di Ruang rapat Lt.1 Kampus 1 Universitas Jenderal Achmad Yani Yogyakarta (Unjaya),  dilakukan Audit Unjaya Tahun 2022 oleh Tim Satuan Pengawas Internal Yayasan Kartika Eka Paksi (SPI YKEP) pada Senin-Rabu, (19-31/5/2023). Tm Audit SPI YKEP dipimpin oleh Ketua SPI YKEP, Brigjen TNI (Purn) Sudarmadi, S.Sos. yang didampingi oleh anggota tim, Kolonel Ckm Ardijon, SH., M.Si., (Itjenad), Kolonel Inf Marthen Pasunda, S.Sos.,M.H., (Itjenad), Letkol Cku Sigit Julianto, SE., (Ditkuad) yang diterima langsung oleh Rektor Unjaya, Prof. Dr. rer.nat.apt. Triana Hertiani, S.Si., M.Si., dan Ketua BPH Unjaya, Rimbo Karyono, S.I.P., M.M., didampingi para pejabat struktural Rektorat dan Dekanat Unjaya.','markdown',NULL,NULL,'Audit Unjaya Tahun 2022 oleh Satuan Pengawas Internal YKEP','publish','http://unjaya.ac.id/audit-unjaya-tahun-2022-oleh-satuan-pengawas-internal-ykep/','http://unjaya.ac.id/audit-unjaya-tahun-2022-oleh-satuan-pengawas-internal-ykep/','audit-unjaya-tahun-2022-oleh-satuan-pengawas-internal-ykep',0,'post','default','https://admin.ykep.org/uploads/original/12/Screenshot_111.png',NULL,'2023-07-13 12:13:42','2023-07-13 12:13:39',NULL),(39,12,'(Humas) – Pada hari Jumat (05/05) telah dilaksanakan serahterima 1 Parsial 3, Parsial 2 Tahap 2 yang diserahterimakan dari PT. Wijaya Karya (PT. Wika) dan PT. Indalex ke Yayasan Kartika Eka Paksi (YKEP), lalu diserahkan kepada Universitas Jenderal Achmad Yani. Kegiatan ini diselenggarakan di Gedung Serbaguna Universitas Jenderal Achmad Yani, dan dihadiri oleh Rektor beserta jajarannya, Ketua YKEP beserta jajaran, para kontraktor, PT. Telkom Indonesia, dan mitra Universitas Jenderal Achmad Yani.','markdown',NULL,NULL,'BAST 1 Parsial 3, BAST Parsial 2 Tahap 2 Pembangunan New Universitas Jenderal Achmad Yani Resmi Diserahterimakan','publish','https://www.unjani.ac.id/bast-1-parsial-3-bast-parsial-2-tahap-2-pembangunan-new-universitas-jenderal-achmad-yani-resmi-diserahterimakan/','https://www.unjani.ac.id/bast-1-parsial-3-bast-parsial-2-tahap-2-pembangunan-new-universitas-jenderal-achmad-yani-resmi-diserahterimakan/','bast-1-parsial-3-bast-parsial-2-tahap-2-pembangunan-new-universitas-jenderal-achmad-yani-resmi-diserahterimakan',0,'post','default','https://admin.ykep.org/uploads/original/12/Screenshot_101.png',NULL,'2023-07-13 12:16:19','2023-07-13 12:16:17',NULL),(40,12,'Humas – Universitas Jenderal Achmad Yani pada tahun 2023 memasuki usianya yang ke-33 yang jatuh pada tanggal 20 Mei. Dengan demikian, dalam rangka memperingati Hari Ulang Tahun (HUT) atau Dies Natalis Universitas Jenderal Achmad Yani, telah dilaksanakan acara Kick-Off atau pembukaan dies dengan mengusung tema Bersama, Berkarya Menuju Keunggulan. Kegiatan ini dilaksanakan di area Gedung Rektorat Universitas Jenderal Achmad Yani pada hari Minggu (29/5) pagi.','markdown',NULL,NULL,'Kick-Off Dies Natalis Universitas Jenderal Achmad Yani ke-33','publish','https://www.unjani.ac.id/kick-off-dies-natalis-universitas-jenderal-achmad-yani-ke-33/','https://www.unjani.ac.id/kick-off-dies-natalis-universitas-jenderal-achmad-yani-ke-33/','kickoff-dies-natalis-universitas-jenderal-achmad-yani-ke33',0,'post','default','https://admin.ykep.org/uploads/original/12/Screenshot_91.png',NULL,'2023-07-13 12:18:50','2023-07-13 12:18:48',NULL),(41,12,'Humas – Tepat pada hari Kamis (27/07) sebanyak 1.894 wisudawan mengikuti kegiatan Sidang Senat Terbuka Dalam Rangka Wisuda, Magister, Profesi, Sarjana Sarjana Terapan, dan Ahli Madya Baru Universitas Jenderal Achmad Yani Periode I dan II. Tema pada kegaiatan ini yaitu “Generasi Unggul di Era Digital Yang Berdaya Saing Global” dan bertempat di HARRIS Hotel & Conventions Festival Citylink Bandung.\r\n\r\n\r\n\r\n\r\n\r\n\r\nKegiatan ini dihadiri oleh Rektor beserta jajaran, Ketua Pengurus Yayasan Kartika Eka Paksi beserta jajaran, Wadan Pussenif TNI AD, Kepala LLDIKTI Wilayah IV, Keluarga Jenderal TNI Achmad Yani, keluarga wisudawan dan tamu lainnya. Diikuti dengan 312 lulusan Magister, 383 lulusan Profesi, 1.174 lulusan Sarjana, 11 lulusan Sarjana Terapan, 14 lulusan Ahli Madya dan 8 diantaranya menjadi lulusan terbaik.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nMahasiswa dengan lulusan terbaik diantaranya Alifa Cahaya S. dari Program Studi Kimia dengan IPK 3,94, Lita Nur Pertiwi dari Program Studi Akuntansi dengan IPK 4.00, Anto Destianto dari Program Studi Magister Teknik Sipil dengan IPK 3,92, Ikin Asikin dari Program Studi Magister Ilmu Pemerintahan dengan IPK 3,97, Titi Nugroho dari Program Studi Teknik Industri dengan IPK 3,79, Ana Yulia Dermayanti dari Program Studi Ilmu Pemerintahan dengan IPK 3,95, Rahmat Saputra dari Program Studi Magister Kimia dengan IPK 3,92, Putri Auliya dari Program Studi Magister Hubungan Internasional dengan IPK 3,94.\r\n\r\nRektor Universitas Jenderal Achmad Yani, Prof. Hikmahanto Juwana, S.H., LL.M., Ph.D dalam laporannya menampilkan tayangan video yang berkaitan dengan perkembangan universitas yang meliputi pembangunan infrastruktur, akademik, pendidikan, kerjasama,  kemahasiswaan,  dan kelembagaan. Selain itu, dalam video yang ditayangkan, diperlihatkan juga kemajuan Universitas Jenderal Achmad Yani saat dipimpin oleh Prof. Hikmahanto Juwana, S.H., LL.M., Ph.D dari tahun 2020 hingga 2023.\r\n\r\n\r\n\r\n\r\nDilanjutkan dengan sambutan Ketua Pengurus YKEP, Letjen TNI (Purn) Dr. Tatang Sulaiman, S.Sos., M.Si. “Jadilah sarjana yang berkarakter, sebagaimana layaknya filosofi kata “SARJANA” yang saya jabarkan dalam abjad berikut ini, “S” atau  sains yang berarti gunakan ilmu, kemampuan, kecakapan dan keahlian, “A” atau akuntabel yang berarti bertanggung jawab wujud kesadaran, “R” atau realistis yang berarti berpikirlah dengan penuh perhitungan, “J” atau juang yang berarti berjuang, bekerja keras dan berusaha, “A” atau achievement yang berarti wujud kesadaran akan meraih keberhasilan, “N” atau normative yang berarti hendak berpedoman dan berpegang teguh terhadap norma, dan yang terakhir “A” atau Amanah yang berarti berupaya agar menjadi orang yang dapat di percaya,” ucap beliau dalam pesannya.\r\n\r\nKegiatan wisuda pada periode I dan II berjalan dengan lancar dan dilaksanakan dengan penuh hikmat, diakhiri dengan pemberian ijazah kepada seluruh wisudawan.\r\n\r\nPenulis : Salma Fithri K (Manajemen)','markdown',NULL,NULL,'Universitas Jenderal Achmad Yani Selenggarakan Wisuda Periode I dan II Tahun 2023','publish','https://www.unjani.ac.id/universitas-jenderal-achmad-yani-selenggarakan-wisuda-periode-i-dan-ii-tahun-2023/','https://www.unjani.ac.id/universitas-jenderal-achmad-yani-selenggarakan-wisuda-periode-i-dan-ii-tahun-2023/','universitas-jenderal-achmad-yani-selenggarakan-wisuda-periode-i-dan-ii-tahun-2023',0,'post','default','https://admin.ykep.org/uploads/original/12/Screenshot_131.png',NULL,'2023-08-03 11:52:05','2023-08-03 11:51:52',NULL),(42,12,'PENGUMUMAN\r\nNomor : Peng/001/UNJAYA/VII/2023\r\n\r\n INFORMASI LOWONGAN KERJA\r\nUNIVERSITAS JENDERAL ACHMAD YANI YOGYAKARTA\r\n\r\nDalam rangka pengembangan Universitas Jenderal Achmad Yani Yogyakarta, dibuka kesempatan untuk berkarir sebagai Dosen (tenaga pendidik) dan Non Dosen (tenaga kependidikan) adapun persyaratan sebagai berikut :\r\n\r\nPersyaratan umum :\r\n\r\nWarga Negara Indonesia.\r\nBerusia setinggi-tingginya 30 tahun untuk pelamar calon pegawai non dosen dan 40 tahun untuk pelamar calon pegawai dosen.\r\nTidak pernah dihukum penjara atau kurungan berdasarkan keputusan pengadilan yang sudah mempunyai kekuatan hukum tetap.\r\nBerbadan sehat yang dibuktikan dengan surat keterangan dari dokter pemerintah.\r\nBerkelakuan baik yang dibuktikan dengan surat keterangan dari Polri.\r\nTidak berkedudukan sebagai pegawai/calon pegawai negeri maupun swasta.\r\nTidak terlibat dalam gerakan yang menentang Pancasila dan Undang-Undang Dasar 1945.\r\nTidak pernah diberhentikan tidak dengan hormat sebagai pegawai suatu instansi pemerintah maupun swasta.\r\nMempunyai pendidikan, kecakapan, dan keahlian sesuai kebutuhan.\r\nBersedia mengabdi sekurang-kurangnya 5 (lima) tahun terhitung sejak pengangkatan menjadi calon pegawai.\r\nMemiliki jenjang pendidikan sesuai dengan yang dibutuhkan.\r\nMemiliki IPK >3.00 bagi Non Dosen dan IPK> 3.25 bagi Dosen\r\nTata Cara Pendaftaran\r\n\r\n1. Pelamar wajib memiliki alamat email yang aktif untuk mengikuti proses seleksi penerimaan Pegawai Universitas Jenderal Achmad Yani Yogyakarta Tahun 2023\r\n2. Pelamar melakukan pendaftaran melalui link https://s.id/RekrutmenUnjaya2023 . Pendaftaran dibuka pada tanggal 20 Juli 2023 dan ditutup pada tanggal 8 Agustus 2023\r\n3. Pelamar wajib mengunggah hasil scan berwarna dokumen asli meliputi :\r\na. Surat lamaran ditujukan kepada Rektor Universitas Jenderal Achmad Yani Yogyakarta\r\nb. Daftar Riwayat Hidup\r\nc. Pas foto berwarna dengan ketentuan latar belakang berwarna biru\r\nd. Ijazah Bagi pelamar yang tinggal menunggu wisuda, dapat menggunakan Surat Keterangan Lulus (SKL)\r\ne. Transkrip Nilai Bagi pelamar yang tinggal menunggu wisuda, dapat menggunakan transkrip sementara\r\nf. Akte Kelahiran\r\ng. Surat Keterangan Catatan Kepolisian (SKCK) yang masih berlaku pada saat pendaftaran\r\nh. Identitas diri (KTP)\r\ni. Surat Pernyatan di atas materai (format dapat di unduh melalui link https://s.id/Formpernyataan\r\nj. Surat Tanda Registrasi Apoteker (STRA) dan Sertifikat Kompetensi (khusus pelamar Dosen Farmasi)\r\nk. Surat Keterangan Pengalaman Kerja (apabila memiliki) dan\r\nl. Dokumen Pendukung Lainnya\r\n\r\nInformasi lebih lengkap mengenai kualifikasi dan persyaratan dapat diunduh melalui link https://s.id/infolokerUnjaya2023\r\nPoster Pengumuman dapat diunduh melalui link https://s.id/PosterlokerUnjaya2023','markdown',NULL,NULL,'Seleksi Penerimaan Pegawai Universitas Jenderal Achmad Yani Yogyakarta Tahun 2023','publish','http://unjaya.ac.id/loker2023/','http://unjaya.ac.id/loker2023/','seleksi-penerimaan-pegawai-universitas-jenderal-achmad-yani-yogyakarta-tahun-2023',0,'post','','https://admin.ykep.org/uploads/original/12/Screenshot_141.png',NULL,'2023-08-03 11:57:30','2023-08-03 11:57:27',NULL);
/*!40000 ALTER TABLE `mein_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_role_privileges`
--

DROP TABLE IF EXISTS `mein_role_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_role_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `privilege` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_role_privileges`
--

LOCK TABLES `mein_role_privileges` WRITE;
/*!40000 ALTER TABLE `mein_role_privileges` DISABLE KEYS */;
INSERT INTO `mein_role_privileges` VALUES (1,4,'post','post',NULL),(2,4,'post','post/index/all/:any',NULL),(3,4,'post','post/index/trash',NULL),(4,4,'post','post/add',NULL),(5,4,'post','post/insert',NULL),(6,4,'post','post/edit/:num',NULL),(7,4,'post','post/update/:num',NULL),(8,4,'post','post/search',NULL),(9,4,'post','post/post/draft',NULL),(10,4,'post','post/publish',NULL),(11,4,'post','post/trash',NULL),(12,4,'post','post/restore',NULL),(13,4,'post','post/delete',NULL),(14,4,'post','post/category',NULL),(15,4,'post','post/category/add/:any',NULL),(16,4,'post','post/category/insert',NULL),(17,4,'post','post/category/edit/:num',NULL),(18,4,'post','post/category/update/:num',NULL),(19,4,'post','post/category/search',NULL),(20,4,'post','post/category/delete',NULL),(21,4,'post','post/tags',NULL),(22,4,'post','post/tags/add',NULL),(23,4,'post','post/tags/insert',NULL),(24,4,'post','post/tags/edit',NULL),(25,4,'post','post/tags/update',NULL),(26,4,'post','post/tags/search',NULL),(27,4,'post','post/tags/delete',NULL),(28,4,'post','settings',NULL),(29,4,'user','user',NULL),(30,4,'user','user/edit/:num',NULL),(31,4,'user','user/update',NULL),(32,4,'user','user/activate/:num',NULL),(33,4,'user','user/block/:num',NULL),(34,4,'user','user/search/:any',NULL),(35,4,'user','user/checkUser/:any',NULL),(36,4,'user','user/add',NULL),(37,4,'user','user/insert',NULL),(38,4,'user','user/delete/:num',NULL),(39,4,'user','user/purge/:num',NULL),(40,4,'user','user/role',NULL),(41,4,'user','user/role/add',NULL),(42,4,'user','user/role/edit/:num',NULL),(43,4,'user','user/role/insert',NULL),(44,4,'user','user/role/update/:num',NULL),(45,4,'user','user/role/delete/:num',NULL),(46,4,'user','user/role/privileges/:num',NULL),(47,4,'user','user/role/update_role_privileges',NULL),(48,4,'user_profile','entry/user_profile',NULL),(49,4,'user_profile','entry/user_profile/add',NULL),(50,4,'user_profile','entry/user_profile/insert',NULL),(51,4,'user_profile','entry/user_profile/edit/:num',NULL),(52,4,'user_profile','entry/user_profile/update/:num',NULL),(53,4,'user_profile','entry/user_profile/delete/:num',NULL),(54,4,'user_profile','entry/user_profile/export_csv',NULL),(55,4,'question','entry/question',NULL),(56,4,'question','entry/question/add',NULL),(57,4,'question','entry/question/insert',NULL),(58,4,'question','entry/question/edit/:num',NULL),(59,4,'question','entry/question/update/:num',NULL),(60,4,'question','entry/question/delete/:num',NULL),(61,4,'question','entry/question/export_csv',NULL),(110,2,'post','post',NULL),(111,2,'post','post/index/all/:any',NULL),(112,2,'post','post/index/trash',NULL),(113,2,'post','post/add',NULL),(114,2,'post','post/insert',NULL),(115,2,'post','post/edit/:num',NULL),(116,2,'post','post/update/:num',NULL),(117,2,'post','post/search',NULL),(118,2,'post','post/post/draft',NULL),(119,2,'post','post/publish',NULL),(120,2,'post','post/trash',NULL),(121,2,'post','post/restore',NULL),(122,2,'post','post/delete',NULL),(123,2,'post','post/category',NULL),(124,2,'post','post/category/add/:any',NULL),(125,2,'post','post/category/insert',NULL),(126,2,'post','post/category/edit/:num',NULL),(127,2,'post','post/category/update/:num',NULL),(128,2,'post','post/category/search',NULL),(129,2,'post','post/category/delete',NULL),(130,2,'post','post/tags',NULL),(131,2,'post','post/tags/add',NULL),(132,2,'post','post/tags/insert',NULL),(133,2,'post','post/tags/edit',NULL),(134,2,'post','post/tags/update',NULL),(135,2,'post','post/tags/search',NULL),(136,2,'post','post/tags/delete',NULL),(137,2,'post','settings',NULL),(138,2,'page','pages',NULL),(139,2,'page','pages/sync',NULL),(140,2,'page','pages/create',NULL),(141,2,'page','pages/edit',NULL),(142,2,'page','pages/delete',NULL),(143,2,'page','pages/builder',NULL),(144,2,'page','pages/builder/savePage',NULL),(145,2,'dashboard','dashboard',NULL),(146,2,'dashboard','dashboard/recent_login',NULL),(147,2,'dashboard','settings',NULL),(148,2,'files','files',NULL),(149,2,'video','entry/video',NULL),(150,2,'video','entry/video/add',NULL),(151,2,'video','entry/video/insert',NULL),(152,2,'video','entry/video/edit/:num',NULL),(153,2,'video','entry/video/update/:num',NULL),(154,2,'video','entry/video/delete/:num',NULL),(155,2,'video','entry/video/export_csv',NULL);
/*!40000 ALTER TABLE `mein_role_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_roles`
--

DROP TABLE IF EXISTS `mein_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_roles`
--

LOCK TABLES `mein_roles` WRITE;
/*!40000 ALTER TABLE `mein_roles` DISABLE KEYS */;
INSERT INTO `mein_roles` VALUES (1,'Super','active','2013-05-13 10:32:53',NULL),(2,'Member','active','2013-05-13 10:32:53','2021-03-27 23:27:54'),(3,'Admin','active','2020-12-28 11:56:37',NULL),(4,'Customer','inactive','2021-03-27 15:55:09','2021-03-27 23:26:44');
/*!40000 ALTER TABLE `mein_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_term_relationships`
--

DROP TABLE IF EXISTS `mein_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_term_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_term_relationships`
--

LOCK TABLES `mein_term_relationships` WRITE;
/*!40000 ALTER TABLE `mein_term_relationships` DISABLE KEYS */;
INSERT INTO `mein_term_relationships` VALUES (9,2,2,0),(20,7,4,0),(21,1,1,0),(25,8,4,0),(31,12,1,0),(34,3,3,0),(36,11,11,0),(37,11,7,0),(40,15,11,0),(45,9,3,0),(48,4,3,0),(49,4,5,0),(50,5,4,0),(62,16,1,0),(65,13,3,0),(67,10,10,0),(70,17,12,0),(71,19,11,0),(72,18,10,0),(73,20,13,0),(80,23,3,0),(81,28,12,0),(82,29,12,0),(84,30,3,0),(87,31,12,0),(89,32,12,0),(91,33,12,0),(93,22,3,0),(95,34,3,0),(96,21,3,0),(103,35,3,0),(104,35,14,0),(105,35,15,0),(109,36,3,0),(110,36,16,0),(111,36,17,0),(112,37,3,0),(113,37,16,0),(114,37,17,0),(130,40,3,0),(131,40,16,0),(132,40,12,0),(136,39,3,0),(137,39,16,0),(138,39,12,0),(142,38,3,0),(143,38,16,0),(144,38,17,0),(146,41,3,0),(147,42,3,0);
/*!40000 ALTER TABLE `mein_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_term_taxonomy`
--

DROP TABLE IF EXISTS `mein_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  KEY `term_id` (`term_id`,`taxonomy`,`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_term_taxonomy`
--

LOCK TABLES `mein_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `mein_term_taxonomy` DISABLE KEYS */;
INSERT INTO `mein_term_taxonomy` VALUES (1,1,'post_category','',0,0),(2,2,'post_category','',0,0),(3,3,'post_category','',0,0),(4,4,'post_category','',0,0),(5,5,'tag','',0,0),(7,7,'tag','',0,0),(10,10,'pdf_category','',0,0),(11,11,'link_category','',0,0),(12,12,'post_category','',0,0),(13,13,'post_category','',0,0),(14,14,'tag','',0,0),(15,15,'tag','',0,0),(16,17,'tag','',0,0),(17,18,'tag','',0,0);
/*!40000 ALTER TABLE `mein_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_terms`
--

DROP TABLE IF EXISTS `mein_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_terms`
--

LOCK TABLES `mein_terms` WRITE;
/*!40000 ALTER TABLE `mein_terms` DISABLE KEYS */;
INSERT INTO `mein_terms` VALUES (1,'Sosial & Agama','Sosial'),(2,'BUMY','kategori-1'),(3,'Pendidikan','kategori-2'),(4,'Mitra','mitra'),(5,'tag-tes','tag-tes'),(7,'Sample','sample'),(10,'test pdf kategori','test-pdf-categori'),(11,'test link pdf','test-link-pdf'),(12,'Unjani','unjani'),(13,'PT Marabunta','PT-Marabunta'),(14,'Informasi Fasilitas KBAD dan KBU Pendaftar yang berasal dari KBAD/KBU dapat mengikuti program penerimaan Mahasiswa Baru (PMB) UNIVERSITAS JENDERAL ACHMAD YANI melalui jalur PMDK','informasi-fasilitas-kbad-dan-kbu-pendaftar-yang-berasal-dari-kbad-kbu-dapat-mengikuti-program-penerimaan-mahasiswa-baru-pmb-universitas-jenderal-achmad-yani-melalui-jalur-pmdk'),(15,' Jalur Undangan','jalur-undangan'),(16,' Jalur Prestasi atau Jalur USM. Definisi KBAD adalah anak/istri/suami yang sah dari anggota TNI-AD atau Pegawai Negeri Sipil TNI-AD baik yang masih aktif maupun sudah pensiun. Definisi KBU adalah anak','jalur-prestasi-atau-jalur-usm-definisi-kbad-adalah-anak-istri-suami-yang-sah-dari-anggota-tni-ad-atau-pegawai-negeri-sipil-tni-ad-baik-yang-masih-aktif-maupun-sudah-pensiun-definisi-kbu-adalah-anak-is'),(17,'Pendidikan','pendidikan'),(18,'Unjaya','unjaya');
/*!40000 ALTER TABLE `mein_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_user_profile`
--

DROP TABLE IF EXISTS `mein_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_user_profile`
--

LOCK TABLES `mein_user_profile` WRITE;
/*!40000 ALTER TABLE `mein_user_profile` DISABLE KEYS */;
INSERT INTO `mein_user_profile` VALUES (1,1,'08987654321','Jl. Cijeungjing Padalarang Bandung Barat','2021-03-28',NULL,NULL,'',NULL,'',NULL,NULL,1,0,NULL,'2021-03-13 06:53:11','2021-03-28 08:39:29','l','single','0','','','','','','',NULL),(4,4,'(+62) 902 2563 6387','Dk. Gajah Mada No. 842, Mojokerto 80186, Maluku','2021-03-27',NULL,NULL,'',NULL,'',NULL,NULL,1,0,NULL,'2021-03-13 06:53:11','2023-07-13 13:04:19','l','single','0','','','','','','',NULL),(12,12,NULL,NULL,'2021-04-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-04-13 12:54:25','2023-05-25 14:15:37','l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mein_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_users`
--

DROP TABLE IF EXISTS `mein_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_users`
--

LOCK TABLES `mein_users` WRITE;
/*!40000 ALTER TABLE `mein_users` DISABLE KEYS */;
INSERT INTO `mein_users` VALUES (1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxIiwiZW1haWwiOiJhZG1pbkBhZG1pbi5jb20iLCJ1c2VybmFtZSI6ImFkbWluIiwiZnVsbG5hbWUiOiJBZG1pbmlzdHJhdG9yIiwicm9sZV9uYW1lIjoiU3VwZXIiLCJyb2xlX2lkIjoiMSIsInRpbWVzdGFtcCI6MTYyMDAyMjM2OH0.c3',NULL,'Administrator','admin@admin.com','admin','','','',NULL,NULL,'$P$BCpsKfrGhWdgEjqiqdk9DORDVXhGm6/','inactive',1,NULL,NULL,NULL,NULL,NULL,'2021-04-14 13:48:46','2021-03-13 06:53:11',NULL),(4,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiI0IiwiZW1haWwiOiJhcmlmaW5oYW5hZmlAZ21haWwuY29tIiwidXNlcm5hbWUiOiJjYWh5YSIsImZ1bGxuYW1lIjoiY2FoeWEiLCJyb2xlX25hbWUiOiJTdXBlciIsInJvbGVfaWQiOiIxIiwidGltZXN0YW1wIjoxNjg5MzMwMjc2fQ.qbm',NULL,'cahya','arifinhanafi@gmail.com','cahya','','','',NULL,NULL,'$P$BFGiHFg/u/uLly0KanSa9.eDDM8hkI0','active',1,NULL,NULL,NULL,NULL,NULL,'2023-07-13 13:10:13','2021-03-13 06:53:11',NULL),(12,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxMiIsImVtYWlsIjoiZXJpQGdtYWlsLmNvbSIsInVzZXJuYW1lIjoiZXJpIiwiZnVsbG5hbWUiOiJFcmkiLCJyb2xlX25hbWUiOiJTdXBlciIsInJvbGVfaWQiOiIxIiwidGltZXN0YW1wIjoxNjkxMDM4NjUxfQ.mkHNrCGq31e-lp41dBH',NULL,'Eri','eri@gmail.com','eri','','','',NULL,NULL,'$P$BHhT.x9SO155yYC1ogESq5CVQfUP2m1','active',1,NULL,NULL,NULL,NULL,NULL,'2023-08-03 11:49:41','2021-04-13 10:51:17',NULL);
/*!40000 ALTER TABLE `mein_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_variables`
--

DROP TABLE IF EXISTS `mein_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mein_variables` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `variable` varchar(100) NOT NULL DEFAULT 'anonymous',
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_variables`
--

LOCK TABLES `mein_variables` WRITE;
/*!40000 ALTER TABLE `mein_variables` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `module` varchar(20) NOT NULL,
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('CI_core',1),('course',1),('post',1),('certificate',1),('variable',1),('payment',2),('author',1),('navigation',1),('user',1),('product',1),('forum',1),('wallet',2),('lessonlog',1),('bot',1),('affiliate',1),('setting',1),('membership',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (16,'Pengurus YKEP dan Jajarannya Meninjauan ke Pabrik Produksi PT Tanaka Daria Utama ','Pengurus beserta Kepala Bidang Yayasan Kartika Eka Paksi (YKEP) melakukan peninjauan ke Pabrik Produksi PT Tanaka Daria Utama di daerah Tangerang untuk mengetahui progres pekerjaan dan berkoordinasi secara rutin terkait dengan pembuatan Interior dan Furniture Meubelair pembangunan gedung kampus New Unjani Cimahi.','https://admin.ykep.org/uploads/original/12/Screenshot_31.png','https://admin.ykep.org/uploads/original/12/Screenshot_31.png','2023-07-13 11:53:34','2023-07-13 12:03:06',NULL),(17,' Hari Perrtama Pra-RUPS BUMY dan Mitra YKEP berlangsung','bertempat di Hotel Aston Kartika Grogol, merupakan hari pertama Pra-RUPS BUMY dan Mitra YKEP berlangsung.\r\nAgenda rapat ini meliputi Evaluasi dan Laporan Pertanggungjawaban Pelaksanaan Kegiatan Perusahaan Tahun Buku 2022 di depan Pengurus, Kepala Bidang, dan Kepala Bagian Yayasan Kartika Eka Paksi.\r\nJadwal rapat Pra-RUPS pada hari pertama yaitu dimulai dengan laporan dari PT. Indotruba Tengah dan PT. Cakrawala Bangun Persada.','https://admin.ykep.org/uploads/original/12/Screenshot_51.png','https://admin.ykep.org/uploads/original/12/Screenshot_51.png','2023-07-13 11:55:59','2023-07-13 12:02:53',NULL),(18,'Pergantian Rektor Universitas Jenderal Achmad Yani Yogyakarta','Yayasan Kartika Eka Paksi mengucapkan terima Kasih dan penghargaan yang setinggi-tingginya kepada Bapak Brigjen TNI (Purn) Dr. Drs. Djoko Susilo, S.T., M.T., IPU., atas Dedikasi dan Pengabdiannya sebagai Rektor Universitas Jenderal Achmad Yani Yogyakarta masa bakti 2018-2023.\r\n\r\nDan juga, Selamat Bertugas kepada Ibu Prof. Dr. rer.nat.apt. Triana Hertiani, S.Si., M.Si. sebagai Rektor Universitas Jenderal Achmad Yani Yogyakarta masa bakti 2023-2027.\r\n\r\nSemangat untuk mewujudkan Universitas Jenderal Achmad Yani Yogyakarta yang Maju, Bermutu, dan Unggul.','https://admin.ykep.org/uploads/original/12/Screenshot_61.png','https://admin.ykep.org/uploads/original/12/Screenshot_61.png','2023-07-13 11:58:01','2023-07-13 11:58:44',NULL),(19,'Selamat dan Sukses kepada Letjen TNI (Purn) Dr. Tatang Sulaiman, S.Sos., M.Si.','Kami segenap Keluarga Besar Yayasan Kartika Eka Paksi mengucapkan:\r\n\r\nSelamat dan Sukses kepada Letjen TNI (Purn) Dr. Tatang Sulaiman, S.Sos., M.Si.\r\natas diraihnya gelar Doktor Bidang Kepemimpinan dan Inovasi Kebijakan di Universitas Gajah Mada, Yogyakarta dengan predikat Cum Laude.','https://admin.ykep.org/uploads/original/12/Screenshot_7.png','https://admin.ykep.org/uploads/original/12/Screenshot_7.png','2023-07-13 11:59:54',NULL,NULL);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_content`
--

DROP TABLE IF EXISTS `product_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_content`
--

LOCK TABLES `product_content` WRITE;
/*!40000 ALTER TABLE `product_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'Membership','https://via.placeholder.com/300x300','membership_48RaOkeY',NULL,'','membership',0,99000,0,NULL,'membership','{\"durasi_akses\":\"99999\"}',1,1,'2021-02-01 04:22:10',NULL,'2021-03-14 02:54:57'),(3,'Amphitol 55AB Cocamidopropyl Betaine Foam Booster Jerigen 5 KG','http://localhost/heroicbit/public/views/kimiajaya/assets/images/896568d7-a106-466b-9ded-8feee2b8ffa5.png.webp','amphitol-55ab-cocamidopropyl-betaine-foam-booster-jerigen-5-kg',NULL,'Berfungsi untuk mengentalkan dan menghasilkan busa / foam booster','default',20000,10000,0,NULL,'default','[]',1,1,'2021-03-14 02:12:37',NULL,NULL),(4,'Oxalic Acid Asam Oksalat 1 KG','http://localhost/heroicbit/public/views/kimiajaya/assets/images/ff0579d3-724e-4cb6-adbd-e02d6dfcf810.png.webp','oxalic-acid-asam-oksalat-1-kg',NULL,'Oxalic Acid digunakan dalam berbagai industri, seperti proses dan pembuatan textile, treatment permukaan logam, penyamakan kulit, dan lain-lain','default',20000,10000,0,NULL,'default','[]',1,1,'2021-03-14 02:13:28',NULL,NULL),(5,'Kaporit Bubuk 60% Chlorine Tjiwi 15 KG','http://localhost/heroicbit/public/views/kimiajaya/assets/images/e5250a34-57ff-4d0b-bba2-fd1d81b87d12.jpg.webp','kaporit-bubuk-60-chlorine-tjiwi-15-kg',NULL,'Kaporit Bubuk dapat digunakan untuk disinfektan pada air minum atau air kolam','default',20000,10000,0,NULL,'default','[]',1,1,'2021-03-14 02:14:04',NULL,NULL),(6,'Tepung Pati Kentang Potato Starch 1KG','http://localhost/heroicbit/public/views/kimiajaya/assets/images/ddff536f-96a5-46f4-88f6-be1ab1c17877.jpeg','tepung-pati-kentang-potato-starch-1kg',NULL,'Tepung pati kentang dapat digunakan untuk berbagai makanan seperti kue, roti dan bakso','default',20000,10000,0,NULL,'default','[]',1,1,'2021-03-14 02:14:39',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_box`
--

DROP TABLE IF EXISTS `question_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_box`
--

LOCK TABLES `question_box` WRITE;
/*!40000 ALTER TABLE `question_box` DISABLE KEYS */;
INSERT INTO `question_box` VALUES (4,'Ryan','ryan@gmail.com','0853784958736','pending','Umum','Testing Message','2021-03-31 11:23:35',NULL,NULL),(5,'Nama','nama@gmail.com','085746758869','pending','Kategori 1','Assalamualaikum','2021-03-31 11:58:13',NULL,NULL),(7,'caca','caca@gmail.com','787','pending','Lain-Lain','test','2021-04-12 07:48:37',NULL,NULL),(8,'cahaya','arifin@gmail.com','09864764','accepted','Prestasi','Saya juara lomba IT','2021-04-12 14:39:42','2021-04-12 14:40:04',NULL),(9,'Hello','hello@mail.com','085123','pending','Lain-Lain','Hello disana','2021-05-30 16:59:02',NULL,NULL),(10,'Agustinus Moris Kristanto','kristantomoris@gmail.com','82111935107','pending','Lain-Lain','Assalamualaikum wr.wb, perkenalkan saya Agustinus Moris Kristanto mahasiswa Unjani Cimahi-Bandung sekaligus Wakil Presiden Mahasiswa. Di Unjani Cimahi-Bandung sendiri banyak sekali permasalahan dari Fasilitas mahasiswa yang berbayar kalau kita mau meminja','2023-08-22 08:08:59',NULL,NULL);
/*!40000 ALTER TABLE `question_box` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_category`
--

DROP TABLE IF EXISTS `question_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_category`
--

LOCK TABLES `question_category` WRITE;
/*!40000 ALTER TABLE `question_category` DISABLE KEYS */;
INSERT INTO `question_category` VALUES (4,'Plagiasi','2021-04-01 06:50:56',NULL,NULL),(5,'Sara','2021-04-01 06:51:19',NULL,NULL),(6,'Salah Cetak','2021-04-01 06:51:34',NULL,NULL),(7,'Lain-Lain','2021-04-01 06:51:53','2021-04-12 07:47:11',NULL),(9,'Prestasi','2021-04-12 14:38:55',NULL,NULL);
/*!40000 ALTER TABLE `question_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (5,'Banner Utama','2','https://admin.ykep.org/uploads/original/4/02.jpg','2021-05-14 05:57:31','2023-07-13 13:13:07',NULL),(6,'Universitas','3','https://admin.ykep.org/uploads/original/4/03.jpg','2021-05-14 05:58:14','2023-07-13 13:13:32',NULL),(7,'New Unjani','4','https://admin.ykep.org/uploads/original/4/04.jpg','2021-05-14 05:58:43','2023-07-13 13:11:36',NULL);
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonies`
--

DROP TABLE IF EXISTS `testimonies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonies`
--

LOCK TABLES `testimonies` WRITE;
/*!40000 ALTER TABLE `testimonies` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
INSERT INTO `video` VALUES (9,'The New Universitas Jenderal Achmad Yani','Rancangan The New Universitas Jenderal Achmad Yani yang merupakan bentuk implementasi dari visi Bapak KASAD untuk mengembangkan Univ. Jenderal Achmad Yani menjadi Universitas yang unggul baik di Nasional maupun Internasional','https://admin.ykep.org/uploads/original/12/Screenshot_5.png','T2Bp7L4yYio','2023-07-13 11:17:38','2023-07-13 11:19:40',NULL),(10,'Profile Universitas Jenderal Achmad Yani','Universitas Jenderal Achmad Yani (UNJANI) berdiri pada tanggal 20 Mei 1990 yang ditetapkan dengan Surat Keputusan Ketua Umum YKEP nomor : 027/ YKEP/1990 tanggal 20 Mei 1990 yang selanjutnya dikukuhkan oleh MENDIKBUD dengan Surat Keputusan nomor : 0512/0/1990 tanggal 9 Agustus 1990. Nama Universitas Jenderal Achmad Yani yang disingkat UNJANI diambil dari salah satu tokoh Prajurit TNI AD, Pahlawan Revolusi Jenderal Achmad Yani. UNJANI merupakan hasil penggabungan sekolah-sekolah tinggi yang dikelola oleh YKEP yaitu : Sekolah Tinggi Teknologi Jenderal Achmad Yani (STTA), Sekolah Tinggi Ilmu Ekonomi Jenderal Achmad Yani (STIEA) dan Sekolah Tinggi Matematika dan Ilmu Pengetahuan Alam (ST MIPA).\r\n\r\nUniversitas Jenderal Achmad Yani sekarang mempunyai 10 Fakultas, yaitu Fakultas Teknik, Fakultas Sains dan Informatika, Fakultas Ekonomi dan Bisnis, Fakultas Ilmu Sosial dan Ilmu Politik, Fakultas Kedokteran, Fakultas Psikologi, Fakultas Farmasi, Fakultas Teknologi Manufaktur, Fakultas Kedokteran Gigi serta Fakultas Ilmu dan Teknologi Kesehatan. Dimana kini UNJANI memiliki 42 pilihan Program Studi yang terdiri dari 4 Prodi Jenjang Vokasi, 24 Prodi jenjang Sarjana, 5 Prodi jenjang Profesi, dan 9 Prodi jenjang Magister.','https://admin.ykep.org/uploads/original/12/Screenshot_3.png','1kekviO49DE','2023-07-13 11:20:48',NULL,NULL),(11,' UNJAYA Selamat Datang #SobatJaya di Kampus Unggul dan Terdepan','niversitas Jenderal Achmad Yani Yogyakarta merupakan Universitas hasil penggabungan/merger berdasarkan Surat Kemenristekdikti nomor 166/KPP/I/2018 tentang izin penggabungan Stikes dan Stmik Jenderal Achmad Yani Yogyakarta. Sebagai Universitas di bawah Yayasan Kartika Eka Paksi TNI Angkatan Darat, Universitas Jenderal Achmad Yani Yogyakarta memiliki banyak \"kekhasan\" yang disesuaikan dengan tuntutan kemajuan teknologi, namun tetap berpegang teguh pada nilai Nasionalsime, Patriotisme, dan Nilai Kejuangan Jenderal Achmad Yani.','https://admin.ykep.org/uploads/original/12/Screenshot_4.png','Wg_HvD47RsU','2023-07-13 11:26:51',NULL,NULL),(12,'Yayasan Kartika Eka Paksi dan Unjani Melaksanakan Rapat Integrasi Pembangunan Kampus','Pada hari Selasa (24/5), bertempat di Aula Gedung Sutan Dikot Harahap Fakultas Kedokteran Universitas Jenderal A. Yani berlangsung pertemuan antara Yayasan Kartika Eka Paksi, Universitas Jenderal A. Yani beserta para kontraktor pembangunan The New Universitas Jenderal A. Yani. Pertemuan ini dihadiri oleh Rektor, Wakil Rektor I, Wakil Rektor II, Wakil Rektor III, Ketua Pengurus Yayasan Kartika Eka Paksi, para Kepala Bidang, Ketua PT. Telkom Indonesia, PT. Indah Karya, PT. Wika, PT Adi Cipta Karya Hernanda, PT. Bakti Wirahusada, Dekan, Direktur RSGM Universitas Jenderal A.Yani beserta para pimpinan di lingkungan universitas.\r\n\r\nKemudian di lanjut dengan adanya harapan yang di sampaikan oeh Ketua Pengurus Yayasan Kartika Eka Paksi Bapak Letnan Jenderal TNI (Purn) Tatang Sulaiman bahwa beliau berharap lebih banyak mendengar laporan progres dari pembangunan kampus Univesitas Jenderal Achmad Yani serta mempertahankan kinerjanya agar proyek terus berjalan dengan baik dan meningkatkan kualitas pembangunan.\r\n\r\nTerakhir dari Bapak Rektor, Prof. Hikmahanto Juana, S.H., LL.M., Ph.D berharap agar progres pembangunan proyek dilakukan tidak terlalu lama karena akan diadakannya pembelajaran secara luring yang dilakukan oleh mahasiswa di Universitas Jenderal A. Yani. Beliau juga menyampaikan agar selalu ada koordinasi selama proyek berlangsung.','https://admin.ykep.org/uploads/original/12/unnamed.jpg','8z79qOwbKJM','2023-07-13 11:32:57','2023-07-13 11:33:20',NULL),(13,'Yayasan Kartika Eka Paksi untuk Kesejahteraan Prajurit⁣ ','Channel ini menyajikan berbagai berita, informasi serta perkembangan seputar TNI AD saat ini. Banyak cerita menarik, unik dan bahkan langka yang dapat menginspirasi kita semua. Selamat menyaksikan dan viralkan, dari TNI AD untuk Indonesia tercinta.','https://admin.ykep.org/uploads/original/12/Screenshot_18.png','r9God0YW2Qg','2023-07-13 11:35:43',NULL,NULL),(14,'PEKERJAAN STRUKTUR ATAP GEDUNG FAKULTAS KEDOKTERAN, PROGRESS 2A MINGGU KE-36 DAN 2B MINGGU KE-14','Berikut adalah overview singkat dari Progress Pembangunan Tahap 2A minggu ke-36, dan Tahap 2B minggu ke-14, periode tanggal 03 JULI s/d 09 JULI 2023.\r\n\r\nPencapaian pesentase realisasi progress tahap 2A pada minggu ini telah mencapai 39,4011%, dari target rencana progress sebesar 38,8574%, dengan deviasi progress sebesar plus 2,4697% sedangkan Pencapaian pesentase realisasi progress tahap 2B telah mencapai 1,7240%, dari target rencana progress sebesar 0,1527%, dengan deviasi progress sebesar plus 1,5713','https://admin.ykep.org/uploads/original/12/Screenshot_24.png','kiSiZgLdb58','2023-07-13 11:40:33',NULL,NULL);
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-04 10:41:25
