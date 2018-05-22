<?php

include '../model/dbconnect.php';

sec_session_start();

// update users row to reflect log out
$email = $_SESSION['uem'];

// fields to update in DB
$fields = array(
    'login_status' => 'false',
    "device_browser_info"=> 'n/a'
);

// where clause for our DB request
$where = array(
    'email'=>$email
);

// do an update on validated users row in database to change logged in status and browser data to false
$update_user_data = Databasecontrols::updateRow('users', $fields, $where);

// Unset all session values
$_SESSION = array();

// Destroy session
session_destroy();

$response = array(
    'status'=> 200,
    'message'=> 'sessions destroyed'
);

exit(json_encode($response));
