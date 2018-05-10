<?php
define('ROOT_PATH', dirname(__DIR__).'/');

require_once ROOT_PATH.'../vendor/autoload.php';
require 'config.php';

$db_details = include 'config.php';

// use Medoo\Medoo;

// echo ROOT_PATH;
// include all model files
$includes = array(
    'connect.php',
    'functions.php',
    'plugins.php',
    'database_controls.php',

);

foreach ($includes as $file) {
    include_once ROOT_PATH ."/model/" .$file;
};
