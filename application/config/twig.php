<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['twig_functions'] = [
	'site_url',
    'base_url',
    'current_url',
    'form_open',
    'set_value',
    'time_ago',
    'isPermitted',
    'ellipsize',
    'form_error',
    'view',
    'redirect',
    'asset',
    'flashdata',
    'set_flashdata',
    'parsedown',
    'strftime',
    'time',
    'in_array',
    'count',
    'getenv',
    'print_code',
    'get_file_url',
    'md5',
    'explode',
    'table_explode',
    'setting_item',
    'starts_with',
    'generate_input',
    'generate_output',
    'embed_entry_script',
    'embed_entry_style',
    'strtotime',
    'dd',
    'json_encode',
    'floor',
    'session'
];

$config['twig_filters'] = [
	'xss_clean',
    'strtotime',
    'strftime'
];
