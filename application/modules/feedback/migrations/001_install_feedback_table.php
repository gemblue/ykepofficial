<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_feedback_table extends CI_Migration 
{
    public function up()
    {
        $this->load->dbforge();
        
        $this->dbforge->add_field("id");
        $this->dbforge->add_field("user_id int(10) NOT NULL");
        $this->dbforge->add_field("rate int(1) NOT NULL");
        $this->dbforge->add_field("comment text NOT NULL");
        $this->dbforge->add_field("object_id int(5) NOT NULL");
        $this->dbforge->add_field("object_type varchar(255) NOT NULL");
        $this->dbforge->add_field("created_at timestamp NULL DEFAULT NULL");
        $this->dbforge->add_field("updated_at timestamp NULL DEFAULT NULL");
        $this->dbforge->add_field("deleted_at timestamp NULL DEFAULT NULL");
        
        $this->dbforge->create_table('feedback', TRUE, array('ENGINE' => 'InnoDB'));
    }

    public function down()
    {
        $this->dbforge->drop_table('feedback', TRUE);
    }
}