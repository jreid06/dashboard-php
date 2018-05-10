<?php

$db_connect_details_local = array(
    'type'=> 'mysql',
    'database_name'=> 'dashboard',
    'host'=> 'localhost',
    'usr'=> 'root',
    'pass'=> 'root'
);

$db_connect_details_staging = array(
    'type'=> 'mysql',
    'database_name'=> 'dashboard',
    'host'=> 'localhost',
    'usr'=> 'root',
    'pass'=> 'root'
);

$db_connect_details_live = array(
    'type'=> 'mysql',
    'database_name'=> 'dashboard',
    'host'=> 'localhost',
    'usr'=> 'root',
    'pass'=> 'root'
);

return array(
    'local'=>$db_connect_details_local,
    'staging'=>$db_connect_details_staging,
    'live'=> $db_connect_details_live
);
