<?php
// $raw_query = "CREATE TABLE `dashboard`.`test_table_2` ( `id` INT(255) NOT NULL AUTO_INCREMENT , `nav_name` TEXT NOT NULL , `nav_id` VARCHAR(200) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
use Ipify\Ip;
use GeoIp2\Database\Reader;

// useful variables

$GLOBALS['admin_user_prefix'] = 'ADMIN_DASHJBR_';
$GLOBALS['user_user_prefix'] = 'USER_DASHJBR_';
$break = "<br><br>";
$pre_top = "<pre>";
$pre_btm = "</pre>";

$GLOBALS['browser_info'] = new Browser();

// configure IP address array as a GLOBAL VARIABLE

$ipify = new Ip();

try {
    $public_ip = $ipify::get();
} catch (\Exception $e) {
    $public_ip = file_get_contents('https://api.ipify.org');
}


// reader
$reader = new Reader(ROOT_PATH.'../GeoLite2-City.mmdb');
$reader_error = false;

try {
    $record = $reader->city($public_ip);
} catch (\Exception $e) {
    $reader_error = true;
}

$GLOBALS['ip_address_data'] = array(
    'public_ip'=> $reader_error ? 'ip error' : $public_ip,
    'country'=> array(
        'iso'=> $reader_error ? 'ip error' : $record->country->isoCode,
        'name'=> $reader_error ? 'ip error' : $record->country->name
    ),
    'city'=> $reader_error ? 'ip error' : $record->city->name,
    'location'=>array(
        'longitude'=> $reader_error ? 'ip error' : $record->location->longitude,
        'latitude'=> $reader_error ? 'ip error' : $record->location->latitude,
    ),
    'user_ip'=> Projectfunctions::getRealIpAddr(),
    'hostname'=> getHostByName(getHostName())
);


// Database configuration variables

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

// return database configuration variables for use in connect Class

return array(
    'local'=>$db_connect_details_local,
    'staging'=>$db_connect_details_staging,
    'live'=> $db_connect_details_live
);
