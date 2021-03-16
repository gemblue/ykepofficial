<?php
/**
 * This is controller used to run installation from cli
 *
 * Command: 
 *      php cli install
 */

class Install extends CI_Controller 
{
    public function index()
    {
        if(!is_cli()) show_error('This only run via cli');
        if(ci()->db->table_exists('mein_options')) die("Installation is already run.\n");

        ci()->output->enable_profiler(false);
        ci()->load->library('migration');

        ci()->migration->migrate_all_modules('latest', true);
        echo "All enabled modules migrated to latest version \n";

        $seed = new App\cli\Seed;
        $seed->run('user');
        $seed->run('setting');
        $seed->run('post');
        $seed->run('membership');
    }
}