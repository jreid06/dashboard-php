<?php

include '../model/dbconnect.php';

sec_session_start();

// check if session values are set e.g token
if (isset($_SESSION['adm_authtoken'])) {

    // means a session exists and user is logged in
    // update users row to reflect log out
    $email = $_SESSION['uem'];
    $session_token = $_SESSION['adm_authtoken'];

    $ip_session_data = $GLOBALS['ip_address_data'];
    $browser_name = $GLOBALS['browser_info']->getBrowser();


    // get sessions array details from database so we can update the array e.g remove deleted session record
    $user_session_data = Databasecontrols::checkDataExists('users', ["sessions_array"], 'email', ["email"=>$email]);

    if (isset($user_session_data['data']['sessions_array'])) {
        $_session_data = json_decode($user_session_data['data']['sessions_array'], true);
        $sesh_length = count($_session_data);

        $pos = '';

        // make sure its not an empty array for sessions
        if ($sesh_length > 0) {
            for ($i=0; $i < $sesh_length; $i++) {
                if ($_session_data[$i]['adm_authtoken'] === $session_token) {
                    // remove this entry from the array
                    $pos = $i;
                }
            }

            array_splice($_session_data, $pos, 1);
        }

        // dont change login status to false if user has other sessions still logged in
        if (count($_session_data) > 0) {
            // fields to update in DB
            $fields = array(
                'sessions_array[JSON]'=>$_session_data
            );
        } else {
            // fields to update in DB
            $fields = array(
                'login_status' => 'false',
                "device_browser_info"=> 'n/a',
                'sessions_array[JSON]'=>$_session_data
            );
        }

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
    }
} else {
    $response = array(
        'status'=> 200,
        'message'=> 'sessions destroyed'
    );

    exit(json_encode($response));
}
