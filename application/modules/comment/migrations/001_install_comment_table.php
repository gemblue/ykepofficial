<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_comment_table extends CI_Migration 
{
    public function up()
    {
        $this->load->dbforge();
        
        $this->dbforge->add_field("id");
        $this->dbforge->add_field("identity varchar(255) NOT NULL");
        $this->dbforge->add_field("user_id int(10) NOT NULL");
        $this->dbforge->add_field("reply_content text NOT NULL");
        $this->dbforge->add_field("reply_status enum('draft','publish','deleted') NOT NULL DEFAULT 'draft'");
        $this->dbforge->add_field("reply_mark varchar(255)");
        $this->dbforge->add_field("created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("updated_at timestamp NULL DEFAULT NULL");
        $this->dbforge->add_field("deleted_at timestamp NULL DEFAULT NULL");

        $this->dbforge->create_table('comment_reply', TRUE, array('ENGINE' => 'InnoDB'));

        $this->dbforge->add_field("id");
        $this->dbforge->add_field("reply_id int(10) NOT NULL");
        $this->dbforge->add_field("user_id int(10) NOT NULL");
        $this->dbforge->add_field("comment_content text NOT NULL");
        $this->dbforge->add_field("comment_status enum('draft','publish','deleted') NOT NULL DEFAULT 'draft'");
        $this->dbforge->add_field("comment_mark varchar(255)");
        $this->dbforge->add_field("created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("updated_at timestamp NULL DEFAULT NULL");
        $this->dbforge->add_field("deleted_at timestamp NULL DEFAULT NULL");

        $this->dbforge->create_table('comment', TRUE, array('ENGINE' => 'InnoDB'));
    }
    
    public function down()
    {
        $this->dbforge->drop_table('comment_reply', TRUE);
        $this->dbforge->drop_table('comment', TRUE);
    }
}