<?php 

namespace App\cli;

class Entry {

	public function __construct()
	{
        ci()->output->enable_profiler(false);
	}

    public function index()
    {
        $entries = get_all_entry_configs();
        ksort($entries);

        echo "Daftar Entry:\n";
        echo "-------------\n";

        foreach ($entries as $entry => $entryConf) {
            echo $entry."\n";
        }
    }

    public function sync($entry = null)
    {
        ci()->load->library('migration');

        $res = ci()->migration->migrate_entry($entry);
        echo strip_tags($res['message'])."\n";
    }

}