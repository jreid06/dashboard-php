<?php

include 'dbconnect.php';

sec_session_start();

if (isset($_GET['q'])) {
    if (!isset($_SESSION['adm_authtoken'])) {
        $response = array(
            'status'=> array(
                'code'=> 400,
                'code_status'=> 'error'
            ),
            'info'=> array(
                'message'=> 'you are not logged in. Please login'
            )
        );
    } else {
        // check if user already exists
        $user_exists = Databasecontrols::checkDataExists('users', ["id","email","password","login_status","permissions"], 'email', ["email"=>$_SESSION['uem']]);

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
                    'id'=>$user_exists['data']['id']
                ),
                'email'=>$_SESSION['uem']
            )
        );
    }
    // sec_session_start();

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
