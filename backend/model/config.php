<?php
$raw_query = "CREATE TABLE `dashboard`.`test_table_2` ( `id` INT(255) NOT NULL AUTO_INCREMENT , `nav_name` TEXT NOT NULL , `nav_id` VARCHAR(200) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

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
