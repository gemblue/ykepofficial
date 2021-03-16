<?php defined('BASEPATH') or exit('No direct script access allowed');

// Post
Route::get('api/post', 'post/api/post/index');
Route::get('api/post/(:any)', 'post/api/post/detail/$1');

// Setting
Route::get('api/setting/(:any)', 'setting/api/setting/detail/$1');

// Variable
Route::get('api/variable/(:any)', 'variable/api/variable/detail/$1');
