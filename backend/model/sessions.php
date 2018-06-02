<?php

include 'dbconnect.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;

// OPTIONAL: Set version truncation to none, so full versions will be returned
// By default only minor versions will be returned (e.g. X.Y)
// for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);

$userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

$dd = new DeviceDetector($userAgent);
$dd->parse();

if ($dd->isBot()) {
    // code...
    $bot = true;
    $bot_data = $dd->getBot();
} else {
    $client_info = $dd->getClient();
    $device = $dd->getDeviceName();
    $model = $dd->getModel();
    $osInfo = $dd->getOs();
}

sec_session_start();

if (isset($_GET['q'])) {
    if (!isset($_SESSION['adm_authtoken'])) {
        $current_ip_address = $GLOBALS['ip_address_data'];
        $current_ip_address['browser'] = $GLOBALS['browser_info']->getBrowser();

        $response = array(
            'status'=> array(
                'code'=> 400,
                'code_status'=> 'error'
            ),
            'info'=> array(
                'message'=> 'you are not logged in. Please login',
                'ip_data'=> $current_ip_address
            )
        );
    } else {
        // check if user already exists
        $user_exists = Databasecontrols::checkDataExists('users', ["admin_id","email","password","login_status","permissions"], 'email', ["email"=>$_SESSION['uem']]);

        $response = array(
            'status'=> array(
                'code'=> 200,
                'code_status'=> 'success'

            ),
            'info'=> array(
                'message'=> 'you are logged in. Dashboard is accessible',
                'user_info'=>array(
                    'permissions'=>$user_exists['data']['permissions'],
                    'email'=>$user_exists['data']['email'],
                    'id'=>explode('_', $user_exists['data']['admin_id'])[2]
                ),
                'email'=>$_SESSION['uem']
            )
        );
    }
    // sec_session_start();

    if ($dd->isTablet()) {
        // code...
        echo "<pre>";
        exit(var_dump($response)."</pre>");
    }

    exit(json_encode($response));
} else {
    $response = array(
        'status'=> array(
            'code'=> 400,
            'code_status'=> 'success'
        ),
        'info'=> array(
            'message'=> 'no data sent'
        )
    );

    exit(json_encode($response));
}
