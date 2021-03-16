<?php 

$ci = &get_instance();
$ci->load->helper('files/filemanager');

$data = get_file_urls($result[$config['field']]);

if($config['original_only'] ?? null)
	$data = $data['original'];

return $data;
