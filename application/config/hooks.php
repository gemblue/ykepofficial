<?php

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_system'][] = function(){
    if(file_exists(APPPATH.'hooks/PreSystemHook.php'))
        (new App\hooks\PreSystemHook)->run();
};

$hook['pre_controller'][] = function(){
    if(file_exists(APPPATH.'hooks/PreControllerHook.php'))
        (new App\hooks\PreControllerHook)->run();
};

$hook['post_controller_constructor'][] = function(){
    if(file_exists(APPPATH.'hooks/PostControllerConstructorHook.php'))
        (new App\hooks\PostControllerConstructorHook)->run();
};