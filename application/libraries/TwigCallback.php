<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TwigCallback
{
    protected $attributes = [];

    function __construct(){}

    function setAttributes($attributes = [])
    {
        $this->attributes = $attributes;
    }

    function getAttribute($name, $default = '')
    {
        return $this->attributes[$name] ?? $default;
    }

    public function output($data, $flag = false)
    {
        if($this->getAttribute('debug'))
            Console::log($data);

        if($flag == 'error')
            if($_ENV['CI_ENV'] == 'production')
                return '';

        return $data;
    }
}