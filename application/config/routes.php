<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Route.php";

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'page/index';
if(is_cli()) $route['default_controller'] = 'command';
$route['404_override'] = 'page/index';
$route['translate_uri_dashes'] = FALSE;

// Referral routes
$route['~([a-zA-Z0-9_-]+)'] 	= 'user/setReferrer';
$route['ref/([a-zA-Z0-9_-]+)'] 	= 'user/setReferrer';

// CLI
$route['command/(.+)']  = 'command/run/$1';

/** 
 *  ADMIN ROUTES
 */
$route['admin'] = 'dashboard/admin/dashboard';

/** 
 *  CUSTOM ADMIN PAGES
 */
$route['admin/page/(.+)']   = 'page/admin/page/index/$1';

// Special route for admin entry
$route['admin/entry/config']                = 'entry/admin/config';
$route['admin/entry/config/(.+)']           = 'entry/admin/config/$1';
$route['admin/entry/(:any)']                = 'entry/admin/entry/index/$1';
$route['admin/entry/(:any)/(:any)']         = 'entry/admin/entry/$2/$1';
$route['admin/entry/(:any)/(:any)/(.+)']    = 'entry/admin/entry/$2/$1/$3';

$route['admin/([a-zA-Z0-9_-]+)']	  = '$1/admin/$1/index';
$route['admin/([a-zA-Z0-9_-]+)/(.+)'] = function ($module, $params) {
    $segs = explode('/', $params);

    // If segs[0] as controller exists, use regular behavior
    $controllerPath = $module . '/controllers/admin/' . ucfirst($segs[0] . '.php');
    foreach (config_item('modules_locations') as $path => $relative) {
        if (file_exists($path . $controllerPath))
            return "$module/admin/$params";
    }

    // Assumes module name and controller name are same
    return "$module/admin/$module/$params";

};

// Include addon API routes
if (file_exists(APPPATH . 'routes/api.php')) include_once APPPATH . 'routes/api.php';
if (file_exists(SITEPATH.'routes/api.php')) include_once SITEPATH.'routes/api.php';
$route = Route::map($route);

/** 
 *  API ROUTES
 */
$route['api/entry/(:any)']                = 'entry/api/entry/index/$1';
$route['api/entry/(:any)/(:any)']         = 'entry/api/entry/$2/$1';
$route['api/entry/(:any)/(:any)/(.+)']    = 'entry/api/entry/$2/$1/$3';

$route['api/([a-zA-Z0-9_-]+)']      = '$1/api/$1/index';
$route['api/([a-zA-Z0-9_-]+)/(.+)'] = function ($module, $params) {
    $segs = explode('/', $params);

    // If segs[0] as controller exists, use regular behavior
    $controllerPath = $module . '/controllers/api/' . ucfirst($segs[0] . '.php');
    foreach (config_item('modules_locations') as $path => $relative) {
        if (file_exists($path . $controllerPath)){
            return "$module/api/$params";
        }
    }

    // Assumes module name and controller name are same
    return "$module/api/$module/$params";
};

// Include addon routes
if(file_exists(APPPATH.'routes/web.php')) include_once(APPPATH.'routes/web.php');
if(file_exists(SITEPATH.'routes/web.php')) include_once(SITEPATH.'routes/web.php');

$route = Route::map($route);
