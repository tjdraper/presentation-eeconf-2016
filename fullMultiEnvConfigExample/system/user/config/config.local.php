<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

defined('SERVER_NAME') or define('SERVER_NAME', $_SERVER['SERVER_NAME']);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config['debug'] = '2';

$db['hostname'] = '127.0.0.1';
$db['username'] = 'homestead';
$db['password'] = 'secret';
$db['database'] = 'homestead';