<?php defined('BASEPATH') OR exit('No direct script access allowed');

Route::get('cmsdocs/(.+)', 'cmsdocs/index/$1');
Route::get('conf', 'user/confirm_activation');
Route::get('rest/(:any)', 'user/change_password/$1');
Route::get('profile/(:any)', 'user/profile/$1');
