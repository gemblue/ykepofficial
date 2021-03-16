<?php defined('BASEPATH') or exit('No direct script access allowed');

Route::get('api/point/(:num)', 'point/api/point/total/$1');
Route::get('api/point/(:num)/rank', 'point/api/point/rank/$1');

Route::post('api/lessonlog', 'lessonlog/api/lessonlog/create');
Route::post('api/lessonlog/(:num)', 'lessonlog/api/lessonlog/update/$1');
