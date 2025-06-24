<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(0);
if (!defined('BASE_URL'))
    define('BASE_URL', 'https://SEU_SITE_C0M/');
if (!defined('base_url'))
    define('base_url', 'https://SEU_SITE_COM/');

if (!defined('base_app'))
    define('base_app', str_replace('\\', '/', __DIR__) . '/');

if (!defined('BASE_APP'))
    define('BASE_APP', str_replace('\\', '/', __DIR__) . '/');
if (!defined('DB_SERVER'))
    define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME'))
    define('DB_USERNAME', 'nome_user_banco');
if (!defined('DB_PASSWORD'))
    define('DB_PASSWORD', 'senha_banco');
if (!defined('DB_NAME'))
    define('DB_NAME', 'nome_banco');
?>