<?php

    include '../model/dbconnect.php';

    if (isset($_GET['stat_type'])) {

        // response
        $response = array(
            'status'=> array(),
            'info'=> array()
        );

        $stat_type = $_GET['stat_type'];

        switch ($stat_type) {
            case 'directory info':
                $stats = new get_stat();
                $directory_info = $stats->directory_space('/');

                $response['status']['code'] = 200;
                $response['status']['message']='success';

                $response['info']['data'] = $directory_info;
                $response['info']['message'] = 'directory information received';

                break;

            default:
                // code...
                break;
        }



        exit(json_encode($response));
    } else {
        // code...

        $response = array(
            'status'=> array(
                'code'=> 400,
                'message'=> 'error',
                'request'=> 'ajax'
            ),
            'info'=> array(
                'message'=> 'error registering user. Error code: <strong>'.$user_added['error_array'][0].'</strong>'
            )
        );

        exit(json_encode($response));
    }
