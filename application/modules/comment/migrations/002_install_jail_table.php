<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_jail_table extends CI_Migration 
{
	public $table = 'comment_jail';

    public function up()
    {
        $this->load->dbforge();
        
        $this->dbforge->add_field("id");
        $this->dbforge->add_field("user_id int(10) NOT NULL");
        $this->dbforge->add_field("failed int(3)");
        $this->dbforge->add_field("jailed boolean");
        $this->dbforge->add_field("created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("updated_at timestamp NULL DEFAULT NULL");
        
        $this->dbforge->create_table($this->table, TRUE, array('ENGINE' => 'InnoDB'));
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table, TRUE);
    }

}