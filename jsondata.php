<?php
include 'backend/model/dbconnect.php';

$stats = new get_stat();
$active_users = $stats->activeAdminUsers();

// var_dump($active_users);

$cache2 = new Cache();

echo "PATH: ".$cache2->getPath();

if ($cache2->get('active_users', $users)) {
    echo $break.'TETESTYSH'.'<br>';
    echo $pre_top;

    var_dump($users);
    echo $pre_btm;
} else {
    echo "'nothing'";
    $cache2->set('active_users', $active_users[1]);
    // echo $path;
}





echo $pre_top;
var_dump($GLOBALS['ip_address_data']);
echo $pre_btm;
