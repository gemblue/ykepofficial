<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_table_jobs extends CI_Migration 
{
    public function up()
    {
        $this->db->query(
            "CREATE TABLE `jobs` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `priority` TINYINT(1) NOT NULL DEFAULT '9',
            `type` VARCHAR(45) NOT NULL,
            `payload` TEXT NULL COMMENT 'JSON payload',
            `response` TEXT NULL,
            `status` ENUM('queued','running','done') NOT NULL DEFAULT 'queued',
            `attempt` TINYINT(1) NULL DEFAULT '0',
            `run_time` DOUBLE NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `expired_at` datetime NULL,
            PRIMARY KEY (`id`));");

        $this->db->query(
            "CREATE TABLE `mein_labels` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `term` varchar(255) NOT NULL,
            `term_slug` varchar(255) NOT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        return true;
    }

    public function down()
    {
        $this->db->query("DROP TABLE `jobs`");
    }
}