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
        $response = array(
            'status'=> array(
                'code'=> 200,
                'code_status'=> 'success'
            ),
            'info'=> array(
                'message'=> 'you are logged in. Dashboard is accessible',
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
