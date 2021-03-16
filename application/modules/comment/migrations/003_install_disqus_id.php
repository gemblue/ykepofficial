<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_disqus_id extends CI_Migration 
{
	public $table = 'people';

    public function up()
    {
        $this->load->dbforge();

        $this->dbforge->add_column('mein_posts', [
            'disqus_id' => ['type' => 'varchar(255)', 'after' => 'id']
        ]);

        $this->dbforge->add_column('comment', [
            'optional_name' => ['type' => 'varchar(255)', 'after' => 'id']
        ]);

        $this->dbforge->add_column('comment_reply', [
            'optional_name' => ['type' => 'varchar(255)', 'after' => 'id'],
            'disqus_id' => ['type' => 'varchar(255)', 'after' => 'id']
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('comment', 'optional_name');
        $this->dbforge->drop_column('comment_reply', 'optional_name');
        $this->dbforge->drop_column('comment_reply', 'disqus_id');
        $this->dbforge->drop_column('mein_posts', 'disqus_id');
    }

}