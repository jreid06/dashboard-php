<?php

include 'backend/model/dbconnect.php';

sec_session_start();

echo $_SERVER['HTTP_USER_AGENT'].$break;
$browser = new Browser();
echo $pre_top;
echo "<strong>BROWSER: </strong>".$browser->getBrowser().$break;
echo "<strong>BROWSER Version: </strong>".$browser->getVersion().$break;
echo "<strong>MOBILE: </strong>".$browser->isMobile().$break;
echo "<strong>TABLET: </strong>".$browser->isTablet().$break;
echo "<strong>FACEBOOK: </strong>".$browser->isFacebook().$break;
echo $break.$break;
echo $browser->__toString();
echo $pre_btm;

$date = generate_current_date();
echo $pre_top;
var_dump($date);
echo $pre_btm;

echo $break;

echo "rset_".bin2hex(random_bytes(10));
echo $break;

var_dump($_SESSION);
echo $break;

$selected_permission = $permissions['superuser'];

echo $pre_top;
echo json_encode($selected_permission);
echo $pre_btm;

// echo $CSRFtoken."<br><br>";

$navigation_plugin = new Plugin('navigation');

$plugin_info = $navigation_plugin->getPluginInfo();

// echo json_encode($plugin_info);

$query_info = array('email'=>'test@gmail.com',
'email2'=>'jasonf@gmail.com');

// var_dump($query_info);

$user_info = Databasecontrols::checkDataExists('users', '*', 'email', $query_info);

echo "<pre>";
var_dump($user_info);
echo "</pre>";
