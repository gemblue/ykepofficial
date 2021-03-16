<?php namespace App\hooks;

/**
 * Define BaseHook abstract class
 * 
 * @package PreSystem
 * @author Toni
 */
abstract class BaseHook 
{
	public function run()
	{
		if($this->methods ?? [])
		{
			foreach ($this->methods as $method)
			{
				$this->$method();
			}
		}
	}
}