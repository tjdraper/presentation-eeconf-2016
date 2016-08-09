<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Custom upload directory paths (array keys must match directory ids)
$config['upload_preferences'] = array(
	4 => array(
		'name' => 'General',
		'server_path' => $uploadsPath . 'general' . DIRECTORY_SEPARATOR,
		'url' => '/uploads/general/'
	)
);