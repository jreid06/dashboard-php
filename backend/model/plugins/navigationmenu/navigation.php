<?php

include '../../dbconnect.php';
include_once 'navlink_structure.php';

/*
    configuration
*/

$table_name = 'dash_navigation';

$plugin_columns = array(
    "id"=>[
        'auto_inc'=> true,
        'primary_key'=> true,
        'type'=>"INT(255)"
        ],
    "dash_nav_name"=>"TEXT(1000)",
    "dash_nav_id"=>"VARCHAR(500)",
    "dash_sub_menu"=>"TEXT(100)",
    "dash_sub_menulinks"=>"TEXT(100)",
    "dash_nav_data"=>"TEXT(10000)" // NOTE: JSON
);

$config_plugin = array(
    "plugin_name" => 'site navigation',
    "plugin_slug" => 'site_navigation',
    "plugin_id" => bin2hex(random_bytes(6)),
    "plugin_table_structure" => $plugin_columns,
    "plugin_table_name" => $table_name
);

/*
    configuration end
*/


$navigation_plugin = new Plugin();

$navigation_plugin->initPlugin($config_plugin);
$navigation_plugin->registerPlugin();


echo $pre_top;
echo $navigation_plugin->initDatabaseTable($table_name, $plugin_columns);
echo $pre_btm;

// echo $break;
// echo $pre_top;
// echo $navigation_plugin->get_response_history_list();
// echo $pre_btm;

// echo $break;
//
// echo $pre_top;
// var_dump($navigation_plugin->response_code);
// echo $pre_btm;



// return $navigation_plugin;
