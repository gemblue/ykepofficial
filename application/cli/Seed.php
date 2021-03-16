<?php 

namespace App\cli;

class Seed {

	public function __construct()
	{
		ci()->output->enable_profiler(false);
		
		if($_ENV['CI_ENV'] == 'production')
			show_error("Seeder is prohibited on production server\n");

        ci()->load->library('migration');
	}

    public function run($module = null)
    {
        if(modules_list()[$module] ?? null){
			$classname = ucfirst($module).'Seeder';
			$path = modules_list()[$module]['path'].'seeds/'.$classname.'.php';
			if(! file_exists($path))
				show_error("Seeder file not found in module $module\n");

			require_once($path);
			$seeder = new $classname;
			$seeder->run();

            echo "Seeds for module $module executed\n";
		
		} else
			echo "Module not found\n";
    }
}