<?php

    include '../model/dbconnect.php';

    if (isset($_GET['stat_type'])) {

        // response
        $response = array(
            'status'=> array(),
            'info'=> array()
        );

        $stat_type = $_GET['stat_type'];
        $stats = new get_stat();

        switch ($stat_type) {
            case 'directory info':
                $directory_info = $stats->directory_space('/');

                $response['status']['code'] = 200;
                $response['status']['message']='success';

                $response['info']['data'] = $directory_info;
                $response['info']['message'] = 'directory information received';

                break;
            case 'active users':
                $active_users = $stats->activeAdminUsers();

                if ($active_users[0]) {
                    $response['status']['code'] = 200;
                    $response['status']['message']='success';

                    $response['info']['data'] = $active_users[1];
                    $response['info']['message'] = 'active users recieved';
                } else {
                    $response['status']['code'] = 400;
                    $response['status']['message']='error';

                    $response['info']['message'] = $active_users[1];
                }

                break;
            case 'all admin users':
                $all_users = $stats->allAdminUsers();

                if ($all_users[0]) {
                    $response['status']['code'] = 200;
                    $response['status']['message']='success';

                    $response['info']['data'] = $all_users[1];
                    $response['info']['message'] = 'all users retrieved';
                } else {
                    $response['status']['code'] = 400;
                    $response['status']['message']='error';

                    $response['info']['message'] = $all_users[1];
                }
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
