<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

$showProfiler = 'n';
$showTemplateDebugging = 'n';

// Define Environment
if (! defined('ENV')) {
	switch ($_SERVER['SERVER_NAME']) {
		case 'www.domain.com':
			define('ENV', 'prod');
			define('SERVER_NAME', 'www.domain.com');
			break;
		case 'staging.domain.com':
			define('ENV', 'stage');
			define('SERVER_NAME', 'staging.domain.com');
			break;
		default:
			define('ENV', 'local');
	}
}

$global = array();

// Do not show PHP errors
$config['debug'] = '0';

// Set up the database
$db = array(
	'hostname' => 'localhost',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'exp_',
	'pconnect' => FALSE
);

// Require environment config file
require 'config.' . ENV . '.php';

// Set the database array to the config
$config['database'] = array (
	'expressionengine' => $db,
);

unset($db);

// Global variables
$global['global:env'] = ENV;

// CSS/JS versioning
$global['global:css_version'] = 1;
$global['global:js_version'] = 1;

// Cache settings
$config['cache_driver'] = 'memcached';
$config['memcached'] = array(
	'host' => '127.0.0.1',
	'port' => 11211,
	'weight' => 1
);
$config['cache_driver_backup'] = 'file';

// Email settings
$mandrillKey = 'xxxxxxxxxxxxxx';

$config['mail_protocol'] = 'smtp';
$config['smtp_server'] = 'smtp.mandrillapp.com';
$config['smtp_port'] = '587';
$config['smtp_username'] = 'info@domain.com';
$config['smtp_password'] = $mandrillKey;

// Domain and protocol logic
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$protocol = $secure ? 'https://' : 'http://';

// Dynamic path settings
$baseUrl = $protocol . SERVER_NAME;
$basePath = $_SERVER['DOCUMENT_ROOT'];
$imagesFolder = 'images';
$imagesPath = $basePath . DIRECTORY_SEPARATOR . $imagesFolder;
$imagesUrl = $baseUrl . '/' . $imagesFolder;
$uploadsPath = $basePath . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

$config['site_index'] = '';
$config['site_url'] = $baseUrl;
$config['cp_url'] = $baseUrl . '/cms/';
$config['theme_folder_path'] = $basePath . '/themes/';
$config['theme_folder_url'] = $baseUrl . '/themes/';
$config['captcha_path'] = $imagesPath . '/captchas/';
$config['captcha_url'] = $imagesUrl . '/captchas/';
$config['avatar_path'] = $imagesPath . '/avatars/';
$config['avatar_url'] = $imagesUrl . '/avatars/';

// Cookie & session settings
$config['cookie_domain'] = '';
$config['cookie_httponly'] = 'y';
$config['cookie_path'] = '';
$config['website_session_type'] = 'c';

// Include upload preferences
require 'config.uploadPreferences.php';

// Template settings
$config['save_tmpl_files'] = 'y';
$config['enable_template_routes'] = 'n';

// Debugging
$config['show_profiler'] = $showProfiler;
$config['template_debugging'] = $showTemplateDebugging;

// Tracking & performance settings
$config['disable_all_tracking'] = 'y';
$config['enable_hit_tracking'] = 'n';
$config['log_referrers'] = 'n';
$config['autosave_interval_seconds'] = '0';

// Control Panel
$config['cp_session_type'] = 'c';
$config['rte_enabled'] = 'n';

// General settings
$config['is_system_on'] = 'y';
$config['allow_extensions'] = 'y';
$config['profile_trigger'] = '7289824634';
$config['use_category_name'] = 'n';
$config['reserved_category_word'] = '';
$config['enable_emoticons'] = 'n';
$config['site_404'] = 'site/_404';
$config['encryption_key'] = 'GK6e10G44rYDsRctSgfAk8Xqiqv4DqjN';

// Marksmin
$config['marksmin_enabled'] = true;
$config['marksmin_xhtml'] = false;

// Setup template-level global variables
global $assign_to_config;

if (! isset($assign_to_config['global_vars'])) {
	$assign_to_config['global_vars'] = array();
}

$assign_to_config['global_vars'] = array_merge(
	$assign_to_config['global_vars'],
	$global
);

// ExpressionEngine config items
$config['app_version'] = '3.3.0';
$config['doc_url'] = 'https://ellislab.com/expressionengine/user-guide/';
$config['multiple_sites_enabled'] = 'n';
// END EE config items


// CodeIgniter config items
$config['uri_protocol']	= 'AUTO';
$config['charset'] = 'UTF-8';
$config['subclass_prefix'] = 'EE_';
$config['log_threshold'] = 0;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['rewrite_short_tags'] = TRUE;
// END CodeIgniter config items
