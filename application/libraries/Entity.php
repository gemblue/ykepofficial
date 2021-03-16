<?php namespace App\libraries;

class Entity {

	function __construct(){}

	// Set data to property
	protected function setProperty($data, $exclude = [])
	{
		foreach($data as $key => $value){
			if(!in_array($key, $exclude))
	            $this->{$key} = $value;
        }
        return $this;
	}

	// Magic method so we can override private properties
    public function __get($property) {
    	if(method_exists($this, 'get_'.$property)){
	    	return $this->{'get_'.$property}();
    	}
	    return get_instance()->$property ?? null;
    }

}