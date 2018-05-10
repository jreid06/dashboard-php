<?php

include 'backend/model/dbconnect.php';

$navigation_plugin = new Plugin('navigation');

$plugin_info = $navigation_plugin->getPluginInfo();

echo json_encode($plugin_info);

$query_info = array('email'=>'test@gmail.com',
'email2'=>'jasonf@gmail.com');

var_dump($query_info);

$user_info = Databasecontrols::checkDataExists('users', '*', 'email', $query_info);

echo "<pre>";
var_dump($user_info);
echo "</pre>";
