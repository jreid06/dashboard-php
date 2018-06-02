<?php
define('ROOT_PATH', dirname(__DIR__).'/');

require_once ROOT_PATH.'../vendor/autoload.php';
require_once ROOT_PATH.'../backend/require_class/Browser.php';
require_once ROOT_PATH.'../backend/cache/cache.php';

// include all model files
$includes = array(
    'connect.php',
    'functions.php',
    'database_controls.php',
    'stats.php',
    'functions_class.php',
    'plugins.php'

);

foreach ($includes as $file) {
    include_once ROOT_PATH ."/model/" .$file;
};

require 'config.php';

$permissions = array(
    'superuser'=>array(
        'add'=>true,
        'edit'=>true,
        'delete'=> true,
        'upload'=> true
    ),
    'editor'=>array(
        'add'=> true,
        'edit'=> true,
        'delete'=> false,
        'upload'=> true
    )
);

// Generate CSRF token
$CSRFtoken = bin2hex(openssl_random_pseudo_bytes(24));

//cache



// $db_details = require 'config.php';
