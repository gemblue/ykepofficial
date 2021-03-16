<?php 

namespace App\cli;

class Cache {

	public function __construct()
	{
        ci()->output->enable_profiler(false);
	}

    public function clear($cacheName = null)
    {
        if(cache()->delete($cacheName.'*'))
            echo "Caches $cacheName deleted";
    }

    public function clearOpcache()
    {
        opcache_reset();
        echo "opcache reset\n";
    }
}