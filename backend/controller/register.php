<?php

    include '../model/dbconnect.php';

    if (isset($_POST)) {
        if (json_decode(file_get_contents("php://input"), true)) {
            $test = 'postman';

            // postman data response
            $user_data = registerAdmin_postman();

            $response = array(
                'status'=> array(
                    'code'=> 200,
                    'message'=> 'success',
                    'request'=> 'postman'
                ),
                'info'=> array(
                    'message'=> 'data was sent. Request successful',
                    'user_data'=> $user_data
                )
            );
        } else {
            $test = 'ajax data';
            $form_data = $_POST['form_data'];

            // get user submitted credentials
            $admin_id = $GLOBALS['admin_user_prefix'].bin2hex(random_bytes(10));
            $email = $form_data['email'];
            $password = $form_data['password'];
            $permissions = $form_data['permissionLevel'];
            $reset_password_code = "rset_".bin2hex(random_bytes(10));

            // validate email again
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid_email = true;
            } else {
                $valid_email = false;
            }

            if ($valid_email) {

                // check if user already exists
                $user_exists = Databasecontrols::checkDataExists('users', ["email"], 'email', ["email"=>$email]);

                if (!$user_exists['data']) {

                    // hash users password
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $current_date = generate_current_date();

                    // add details to database

                    $fields = array(
                        'admin_id'=> $admin_id,
                        'email' => $email,
                        'password' => $hash_password,
                        'createdAt' => $current_date['readable_date_db'],
                        'updatedAt' => $current_date['readable_date_db'],
                        'permissions'=> $permissions,
                        'login_status'=> 'false',
                        'device_browser_info' => 'n/a',
                        'reset_password_code'=> $reset_password_code
                    );

                    $user_added = Databasecontrols::insert('users', $fields);

                    if ($user_added['data']) {
                        // response
                        $response = array(
                            'status'=> array(
                                'code'=> 200,
                                'message'=> 'success',
                                'request'=> 'ajax'
                            ),
                            'info'=> array(
                                'message'=> 'Admin account for <strong><i>"'.$email.'"</i></strong> has been created successfully'
                            )
                        );
                    } else {
                        // response

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
                    }
                } else {

                    // // NOTE: USER exists with entered email

                    $response = array(
                        'status'=> array(
                            'code'=> 400,
                            'message'=> 'error',
                            'request'=> 'ajax'
                        ),
                        'info'=> array(
                            'message'=> 'A user with <strong><i>"'.$email.'"</i></strong> already exists',
                            'exists'=> $user_exists
                        )
                    );
                }
            } else {

                // response

                $response = array(
                    'status'=> array(
                        'code'=> 400,
                        'message'=> 'error',
                        'request'=> 'ajax'
                    ),
                    'info'=> array(
                        'message'=> 'email entered isnt valid. Try again'
                    )
                );
            }
        }

        exit(json_encode($response));
    } else {
        $response = array(
            'status'=> array(
                'code'=> 400,
                'message'=> 'error'
            ),
            'info'=> array(
                'message'=> 'No data was sent. Request unsuccessful'
            )
        );

        exit(json_encode($response));
    }
