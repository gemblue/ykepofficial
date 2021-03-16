<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_product_tables extends CI_Migration 
{
    public function up()
    {
        $this->db->query(
            "CREATE TABLE `product_content` (
                `id` int unsigned NOT NULL AUTO_INCREMENT,
                `product` int NOT NULL,
                `image` varchar(255) NOT NULL,
                `caption` text NOT NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                `deleted_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query(
            "CREATE TABLE `products` (
                `id` int NOT NULL AUTO_INCREMENT,
                `product_name` varchar(255) NOT NULL DEFAULT 'Anonymous',
                `product_image` varchar(255) NOT NULL DEFAULT 'http://via.placeholder.com/300x300',
                `product_slug` varchar(255) NOT NULL DEFAULT 'Anonymous',
                `custom_landing_url` varchar(255) DEFAULT NULL,
                `product_desc` text,
                `product_type` varchar(20) NOT NULL DEFAULT 'default',
                `normal_price` bigint DEFAULT NULL,
                `retail_price` bigint NOT NULL DEFAULT '10',
                `count_expedition` tinyint(1) DEFAULT NULL,
                `object_id` bigint DEFAULT NULL,
                `object_type` varchar(50) DEFAULT NULL,
                `custom_data` text,
                `publish` tinyint(1) NOT NULL DEFAULT '1',
                `active` tinyint(1) NOT NULL DEFAULT '1',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                `deleted_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query(
            "CREATE TABLE `subscribers` (
                `id` int NOT NULL AUTO_INCREMENT,
                `followup` tinyint DEFAULT NULL,
                `subscribe_status` varchar(255) DEFAULT 'publish',
                `user_id` int NOT NULL,
                `order_id` int NOT NULL,
                `date_expired` date DEFAULT NULL,
                `subscribe_product_id` int DEFAULT NULL,
                `subscribe_object_id` int DEFAULT NULL COMMENT 'course path id',
                `subscribe_object_type` varchar(50) NOT NULL DEFAULT 'path',
                `daily_credit` int DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `subscribe_status` (`subscribe_status`,`user_id`,`subscribe_object_type`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ");
    }

    public function down()
    {
        $this->dbforge->drop_table('product_content', TRUE);
        $this->dbforge->drop_table('products', TRUE);
        $this->dbforge->drop_table('subscribers', TRUE);
    }

}