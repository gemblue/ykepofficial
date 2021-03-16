-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2021 at 02:35 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ykep`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE `accesslog` (
  `id` int(9) NOT NULL,
  `user_id` int(11) NOT NULL,
  `object_type` varchar(20) NOT NULL,
  `object_id` int(11) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `referer_url` varchar(255) DEFAULT NULL,
  `access_type` enum('f','p','m') NOT NULL DEFAULT 'm' COMMENT 'f:free, p:paid, m:membership',
  `date_access` date NOT NULL,
  `viewed` tinyint(3) NOT NULL DEFAULT 1,
  `learned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT 9,
  `type` varchar(45) NOT NULL,
  `payload` text DEFAULT NULL COMMENT 'JSON payload',
  `response` text DEFAULT NULL,
  `status` enum('queued','running','done') NOT NULL DEFAULT 'queued',
  `attempt` tinyint(1) DEFAULT 0,
  `run_time` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mein_labels`
--

CREATE TABLE `mein_labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `term` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mein_navigations`
--

CREATE TABLE `mein_navigations` (
  `id` int(9) NOT NULL,
  `area_id` int(11) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `url` text DEFAULT NULL,
  `url_type` enum('uri','external') NOT NULL DEFAULT 'uri',
  `target` enum('_blank','_self','_top','_parent') DEFAULT '_self',
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `parent` int(11) DEFAULT NULL,
  `nav_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mein_navigation_areas`
--

CREATE TABLE `mein_navigation_areas` (
  `id` int(9) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `area_slug` varchar(100) NOT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mein_options`
--

CREATE TABLE `mein_options` (
  `id` int(11) NOT NULL,
  `option_group` varchar(30) DEFAULT 'site',
  `option_name` varchar(30) DEFAULT NULL,
  `option_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_options`
--

INSERT INTO `mein_options` (`id`, `option_group`, `option_name`, `option_value`) VALUES
(1448, 'site', 'site_title', 'Ykep Official'),
(1449, 'site', 'site_desc', ''),
(1450, 'site', 'site_logo', ''),
(1451, 'site', 'site_logo_small', ''),
(1452, 'site', 'phone', '087778086140'),
(1453, 'site', 'email', 'hello@ykep.com'),
(1454, 'site', 'maps', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7921.492039980645!2d107.586337!3d-6.920936!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb0b460bfaecab919!2sKimia%20Jaya!5e0!3m2!1sen!2sid!4v1615693883177!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),
(1455, 'site', 'ga', '<script>\r\n(function(w,d,s,g,js,fjs){\r\n  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};\r\n  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];\r\n  js.src=\'https://apis.google.com/js/platform.js\';\r\n  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load(\'analytics\')};\r\n}(window,document,\'script\'));\r\n</script>'),
(1456, 'site', 'address', ''),
(1457, 'site', 'enable_registration', 'on'),
(1458, 'theme', 'admin_logo_bg', '333333'),
(1459, 'theme', 'navbar_color', 'FFFFFF'),
(1460, 'theme', 'navbar_text_color', '333333'),
(1461, 'theme', 'link_color', 'E84A94'),
(1462, 'theme', 'btn_primary', '007BFF'),
(1463, 'theme', 'btn_secondary', '6C757D'),
(1464, 'theme', 'btn_success', '28A745'),
(1465, 'theme', 'btn_info', '138496'),
(1466, 'theme', 'btn_warning', 'E0A800'),
(1467, 'theme', 'btn_danger', 'DC3545'),
(1468, 'theme', 'admin_color', 'blue'),
(1469, 'theme', 'facebook_pixel_code', ''),
(1470, 'theme', 'gtag_id', ''),
(1471, 'emailer', 'use_mailcatcher', 'yes'),
(1472, 'emailer', 'smtp_host', 'in-v3.mailjet.com'),
(1473, 'emailer', 'smtp_port', '587'),
(1474, 'emailer', 'smtp_username', '8443024b25c98692c6e2647372c7be5f'),
(1475, 'emailer', 'smtp_password', ''),
(1476, 'emailer', 'email_from', 'contact@kimiajaya.com'),
(1477, 'emailer', 'sender_name', 'Kimia Jaya'),
(1478, 'post', 'posttype_config', 'page:\r\n    label: Pages\r\n    entry: mein_post_page\r\nevent:\r\n    label: Events\r\n    entry: mein_post_event\r\n'),
(1479, 'user', 'confirmation_type', 'link'),
(1480, 'user', 'use_single_login', 'yes'),
(1481, 'product', 'enable', 'off'),
(1482, 'product', 'remind_expired', '3'),
(1483, 'dashboard', 'maintenance_mode', 'off'),
(1484, 'sample', 'enable', 'off'),
(1485, 'sample', 'title', '');

-- --------------------------------------------------------

--
-- Table structure for table `mein_posts`
--

CREATE TABLE `mein_posts` (
  `id` int(11) NOT NULL,
  `author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `content` longtext NOT NULL,
  `content_type` varchar(20) NOT NULL DEFAULT 'markdown',
  `intro` text DEFAULT NULL,
  `featured` datetime DEFAULT NULL,
  `title` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `total_seen` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'post',
  `template` varchar(30) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `embed_video` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_posts`
--

INSERT INTO `mein_posts` (`id`, `author`, `content`, `content_type`, `intro`, `featured`, `title`, `status`, `slug`, `total_seen`, `type`, `template`, `featured_image`, `embed_video`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test', 'markdown', NULL, NULL, 'Sample Post', 'draft', 'sample-post', 0, 'post', '', 'http://codepolitan.local/themes/belajarcoding/assets/img/default-thumb.jpg', '', NULL, '2021-03-14 09:42:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mein_roles`
--

CREATE TABLE `mein_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_roles`
--

INSERT INTO `mein_roles` (`id`, `role_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'active', '2013-05-13 10:32:53', NULL),
(2, 'Writer', 'active', '2013-05-13 10:32:53', NULL),
(3, 'Member', 'active', '2013-05-13 10:32:53', NULL),
(4, 'Admin', 'active', '2020-12-28 11:56:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mein_role_privileges`
--

CREATE TABLE `mein_role_privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `privilege` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mein_terms`
--

CREATE TABLE `mein_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_terms`
--

INSERT INTO `mein_terms` (`term_id`, `name`, `slug`) VALUES
(1, 'Member Updates', 'member-updates');

-- --------------------------------------------------------

--
-- Table structure for table `mein_term_relationships`
--

CREATE TABLE `mein_term_relationships` (
  `id` int(11) NOT NULL,
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mein_term_taxonomy`
--

CREATE TABLE `mein_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_term_taxonomy`
--

INSERT INTO `mein_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'post_category', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mein_users`
--

CREATE TABLE `mein_users` (
  `id` int(11) NOT NULL,
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
  `password` tinytext DEFAULT NULL,
  `status` varchar(20) DEFAULT 'inactive',
  `role_id` int(11) DEFAULT 3,
  `token` varchar(150) DEFAULT NULL,
  `cdn_token` text DEFAULT NULL,
  `mail_unsubscribe` tinyint(1) DEFAULT NULL,
  `mail_invalid` tinyint(1) DEFAULT NULL,
  `mail_bounce` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_users`
--

INSERT INTO `mein_users` (`id`, `session_id`, `source_id`, `name`, `email`, `username`, `short_description`, `avatar`, `url`, `referral_code`, `referrer_id`, `password`, `status`, `role_id`, `token`, `cdn_token`, `mail_unsubscribe`, `mail_invalid`, `mail_bounce`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxIiwiZW1haWwiOiJhZG1pbkBhZG1pbi5jb20iLCJ1c2VybmFtZSI6ImFkbWluIiwiZnVsbG5hbWUiOiJNaW1pbiIsInJvbGVfbmFtZSI6IlN1cGVyIiwicm9sZV9pZCI6IjEiLCJ0aW1lc3RhbXAiOjE2MTU4OTkwMjF9.9u8qMalxDdswz', NULL, 'Mimin', 'admin@admin.com', 'admin', NULL, NULL, NULL, NULL, NULL, '$P$BCpsKfrGhWdgEjqiqdk9DORDVXhGm6/', 'active', 1, NULL, NULL, NULL, NULL, NULL, '2021-03-16 06:10:28', '2021-03-13 06:53:11', NULL),
(2, NULL, NULL, 'Test User', 'test@test.com', 'test', NULL, NULL, NULL, NULL, NULL, '$P$Bh.aHZ95u8lbdIAENIHu4/7lJOQgZz1', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(3, NULL, NULL, 'Ajiono Gunawan M.Ak', 'rina66@gmail.com', 'jarwa61', NULL, NULL, NULL, NULL, NULL, '$P$Bel8RQ4Oqa5AjSg7oB6iL/Qj2IN2be/', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(4, NULL, NULL, 'Jane Hasanah S.Gz', 'tina.suartini@yahoo.co.id', 'zrahmawati', NULL, NULL, NULL, NULL, NULL, '$P$BqV4Yo6Dom51t3NYYCGjI6H2AKbBZi/', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(5, NULL, NULL, 'Jamil Waluyo', 'mulyani.sadina@dabukke.web.id', 'aoktaviani', NULL, NULL, NULL, NULL, NULL, '$P$BZ5TpnCjEReTOIJMUd8Yon3mIZULmN.', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(6, NULL, NULL, 'Nadia Restu Laksmiwati', 'npuspasari@yahoo.com', 'victoria.ramadan', NULL, NULL, NULL, NULL, NULL, '$P$B82J28hFlkMeKfkb1apUbUyG8HaZL5/', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(7, NULL, NULL, 'Padmi Padmasari', 'elisa.palastri@yahoo.co.id', 'irma75', NULL, NULL, NULL, NULL, NULL, '$P$BUvsPnU1JsOFSiIa9U7CjwW7sPBSV6.', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(8, NULL, NULL, 'Maida Melani S.Kom', 'tami35@siregar.co.id', 'ismail32', NULL, NULL, NULL, NULL, NULL, '$P$BW/SYjdMhuPunsR6qzbV9lsm/LhR6H/', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(9, NULL, NULL, 'Gangsa Saputra', 'vanesa41@megantara.info', 'tasnim45', NULL, NULL, NULL, NULL, NULL, '$P$BXzpUSNHEJFSHdWgWRHDWh79k03p2n1', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL),
(10, NULL, NULL, 'Ika Zulaika S.Ked', 'dongoran.luthfi@zulkarnain.biz', 'ulya.adriansyah', NULL, NULL, NULL, NULL, NULL, '$P$BmgIfWPysepJ1lu7on8ySf7Of3DWkv/', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-13 06:53:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mein_user_profile`
--

CREATE TABLE `mein_user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `interest` text DEFAULT NULL,
  `experience` tinyint(4) DEFAULT NULL,
  `jobs` varchar(255) DEFAULT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `portfolio_link` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT 1,
  `ready_to_work` tinyint(1) DEFAULT 0,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mein_user_profile`
--

INSERT INTO `mein_user_profile` (`id`, `user_id`, `phone`, `address`, `birthday`, `interest`, `experience`, `jobs`, `profession`, `city`, `portfolio_link`, `description`, `newsletter`, `ready_to_work`, `latest_ip`, `created_at`, `updated_at`, `gender`, `status_marital`, `record_log`, `akun_ig`, `akun_tiktok`, `hobi`, `nomor_rekening`, `bank`, `pemilik_rekening`, `deleted_at`) VALUES
(1, 1, '08987654321', 'Jl. Cijeungjing Padalarang Bandung Barat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, '08981234567', 'Jl. Cijeungjing Padalarang Bandung Barat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '(+62) 595 8854 4699', 'Jr. Cikutra Barat No. 809, Administrasi Jakarta Selatan 39354, KalTeng', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '(+62) 902 2563 6387', 'Dk. Gajah Mada No. 842, Mojokerto 80186, Maluku', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, '(+62) 782 4789 829', 'Jln. Bakit  No. 991, Madiun 81585, Bengkulu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '0445 8390 027', 'Jln. Moch. Toha No. 800, Lhokseumawe 38929, SulBar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, '(+62) 274 1567 9231', 'Dk. Gardujati No. 761, Depok 36160, JaBar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, '(+62) 898 078 833', 'Kpg. Suryo No. 647, Ternate 53287, KepR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, '0766 5374 976', 'Ki. Flora No. 603, Pekanbaru 28962, BaBel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, '(+62) 766 1987 3552', 'Psr. Ters. Kiaracondong No. 926, Parepare 25856, SulUt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-03-13 06:53:11', NULL, 'l', 'single', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mein_variables`
--

CREATE TABLE `mein_variables` (
  `id` int(9) NOT NULL,
  `variable` varchar(100) NOT NULL DEFAULT 'anonymous',
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `module` varchar(20) NOT NULL,
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`module`, `version`) VALUES
('CI_core', 1),
('course', 1),
('post', 1),
('certificate', 1),
('variable', 1),
('payment', 2),
('author', 1),
('navigation', 1),
('user', 1),
('product', 1),
('forum', 1),
('wallet', 2),
('lessonlog', 1),
('bot', 1),
('affiliate', 1),
('setting', 1),
('membership', 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `product_image` varchar(255) NOT NULL DEFAULT 'http://via.placeholder.com/300x300',
  `product_slug` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `custom_landing_url` varchar(255) DEFAULT NULL,
  `product_desc` text DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'default',
  `normal_price` bigint(20) DEFAULT NULL,
  `retail_price` bigint(20) NOT NULL DEFAULT 10,
  `count_expedition` tinyint(1) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `object_type` varchar(50) DEFAULT NULL,
  `custom_data` text DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_image`, `product_slug`, `custom_landing_url`, `product_desc`, `product_type`, `normal_price`, `retail_price`, `count_expedition`, `object_id`, `object_type`, `custom_data`, `publish`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Membership', 'https://via.placeholder.com/300x300', 'membership_48RaOkeY', NULL, '', 'membership', 0, 99000, 0, NULL, 'membership', '{\"durasi_akses\":\"99999\"}', 1, 1, '2021-02-01 04:22:10', NULL, '2021-03-14 02:54:57'),
(3, 'Amphitol 55AB Cocamidopropyl Betaine Foam Booster Jerigen 5 KG', 'http://localhost/heroicbit/public/views/kimiajaya/assets/images/896568d7-a106-466b-9ded-8feee2b8ffa5.png.webp', 'amphitol-55ab-cocamidopropyl-betaine-foam-booster-jerigen-5-kg', NULL, 'Berfungsi untuk mengentalkan dan menghasilkan busa / foam booster', 'default', 20000, 10000, 0, NULL, 'default', '[]', 1, 1, '2021-03-14 02:12:37', NULL, NULL),
(4, 'Oxalic Acid Asam Oksalat 1 KG', 'http://localhost/heroicbit/public/views/kimiajaya/assets/images/ff0579d3-724e-4cb6-adbd-e02d6dfcf810.png.webp', 'oxalic-acid-asam-oksalat-1-kg', NULL, 'Oxalic Acid digunakan dalam berbagai industri, seperti proses dan pembuatan textile, treatment permukaan logam, penyamakan kulit, dan lain-lain', 'default', 20000, 10000, 0, NULL, 'default', '[]', 1, 1, '2021-03-14 02:13:28', NULL, NULL),
(5, 'Kaporit Bubuk 60% Chlorine Tjiwi 15 KG', 'http://localhost/heroicbit/public/views/kimiajaya/assets/images/e5250a34-57ff-4d0b-bba2-fd1d81b87d12.jpg.webp', 'kaporit-bubuk-60-chlorine-tjiwi-15-kg', NULL, 'Kaporit Bubuk dapat digunakan untuk disinfektan pada air minum atau air kolam', 'default', 20000, 10000, 0, NULL, 'default', '[]', 1, 1, '2021-03-14 02:14:04', NULL, NULL),
(6, 'Tepung Pati Kentang Potato Starch 1KG', 'http://localhost/heroicbit/public/views/kimiajaya/assets/images/ddff536f-96a5-46f4-88f6-be1ab1c17877.jpeg', 'tepung-pati-kentang-potato-starch-1kg', NULL, 'Tepung pati kentang dapat digunakan untuk berbagai makanan seperti kue, roti dan bakso', 'default', 20000, 10000, 0, NULL, 'default', '[]', 1, 1, '2021-03-14 02:14:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_content`
--

CREATE TABLE `product_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `product` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `content` text NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslog`
--
ALTER TABLE `accesslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_labels`
--
ALTER TABLE `mein_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_navigations`
--
ALTER TABLE `mein_navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_navigation_areas`
--
ALTER TABLE `mein_navigation_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_options`
--
ALTER TABLE `mein_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_posts`
--
ALTER TABLE `mein_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `featured` (`featured`,`status`,`type`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `mein_roles`
--
ALTER TABLE `mein_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_role_privileges`
--
ALTER TABLE `mein_role_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_terms`
--
ALTER TABLE `mein_terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `mein_term_relationships`
--
ALTER TABLE `mein_term_relationships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mein_term_taxonomy`
--
ALTER TABLE `mein_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD KEY `term_id` (`term_id`,`taxonomy`,`parent`);

--
-- Indexes for table `mein_users`
--
ALTER TABLE `mein_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `source_id` (`source_id`);

--
-- Indexes for table `mein_user_profile`
--
ALTER TABLE `mein_user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mein_variables`
--
ALTER TABLE `mein_variables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_content`
--
ALTER TABLE `product_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslog`
--
ALTER TABLE `accesslog`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_labels`
--
ALTER TABLE `mein_labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_navigations`
--
ALTER TABLE `mein_navigations`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_navigation_areas`
--
ALTER TABLE `mein_navigation_areas`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_options`
--
ALTER TABLE `mein_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1486;

--
-- AUTO_INCREMENT for table `mein_posts`
--
ALTER TABLE `mein_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mein_roles`
--
ALTER TABLE `mein_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mein_role_privileges`
--
ALTER TABLE `mein_role_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_terms`
--
ALTER TABLE `mein_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mein_term_relationships`
--
ALTER TABLE `mein_term_relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mein_term_taxonomy`
--
ALTER TABLE `mein_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mein_users`
--
ALTER TABLE `mein_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mein_user_profile`
--
ALTER TABLE `mein_user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mein_variables`
--
ALTER TABLE `mein_variables`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_content`
--
ALTER TABLE `product_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
