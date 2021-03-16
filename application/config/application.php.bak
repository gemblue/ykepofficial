<?php defined('BASEPATH') || exit('No direct script access allowed');

//------------------------------------------------------------------------------
// Module Locations
//------------------------------------------------------------------------------
// These paths are checked in the order listed when attempting to locate a module,
// whether loading a library, helper, or routes file.
//
$config['modules_locations'] = array(
    SITEPATH.'modules/' => '../'.SITEPATH.'modules/',
    APPPATH.'modules/' => '../modules/',
);

// PSR-4 paths, config here is deprecated
// $config['psr4'] = [
//     'App' => APPPATH,
//     'Site' => SITEPATH,
// ];

// Cache Configurations
$config['cache_config'] = [
    'File' => [
        'file_path' => SITEPATH.'caches/'
    ],
    'Memcached' => [
        'host' => 'localhost',
        'port' => 11211,
        'persistence' => true
    ],
    'Redis' => [
        'host' => 'localhost',
        'port' => 6379
    ]
];

//------------------------------------------------------------------------------
// Layouts
//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
// DEFAULT LAYOUT
//------------------------------------------------------------------------------
// This is the name of the default layout used if no others are specified.
// NOTE: do not include an ending ".php" extension.
$config['template.default_layout'] = "basic";

//------------------------------------------------------------------------------
// DEFAULT THEME
//------------------------------------------------------------------------------
// This is the folder name that contains the default theme to use when
// 'template.use_mobile_themes' is set to true.
$config['template.default_theme']	= 'theme';

//------------------------------------------------------------------------------
// DEFAULT THEME
//------------------------------------------------------------------------------
// This is the folder name that contains the default theme to use when
// 'template.use_mobile_themes' is set to true.
$config['template.child_theme']   = 'theme_child';

//------------------------------------------------------------------------------
// ADMIN THEME
//------------------------------------------------------------------------------
// This is the folder name that contains the default admin theme to use
$config['template.admin_theme'] = 'admin';

//------------------------------------------------------------------------------
// TITLE SEPARATOR
//------------------------------------------------------------------------------
// Used to separate title and subtitle in title tag
$config['title_separator'] = '-';

// The 'queue.limit_job' setting is used to specify how many row to fetch from 
// jobs table to work every schedule
$config['queue.limit_job'] = 5;


// The 'assets.encode' setting is used to specify whether the assets should be
// encoded based on the HTTP_ACCEPT_ENCODING value.
$config['whoops_blacklist'] = [
    '_GET' => [],
    '_POST' => [],
    '_FILES' => [],
    '_COOKIE' => [],
    '_SESSION' => [],
    '_SERVER' => [],
    '_ENV' => ['ENC_KEY','REMOTE_ADDR','SERVER_ADDR','SERVER_SOFTWARE','HTTP_COOKIE','DBHOST','DBUSER','DBPASS','DBNAME','DBNAME_MASTER','SMTP_HOST','SMTP_USER','SMTP_PASS','MIDTRANS_SERVER_KEY_PRODUCTION','MIDTRANS_CLIENT_KEY_PRODUCTION','WOOWA_LICENSE','WOOWA_DOMAIN','WOOWA_KEY','WOOWA_IP','SESS_SAVE_PATH','SENTRY_DSN'],
];

// File Manager URL
$config['file_manager_url'] = $_ENV['FILE_MANAGER_URL'] ?? 'local';
