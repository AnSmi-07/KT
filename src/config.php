<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'K-TOVARIKI');
define('DB_PREFIX', 'KT_');
define('SECRET', 'HAHAHA');

set_include_path(get_include_path() . PATH_SEPARATOR . 'src');
spl_autoload_register();
?>