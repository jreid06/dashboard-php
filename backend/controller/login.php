<?php
    // session_start();
    include '../model/dbconnect.php';

    if (isset($_POST['form_data'])) {
        $user_data = $_POST['form_data'];
        $email = $user_data['email'];
        $password = $user_data['password'];

        // validate email again
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid_email = true;
        } else {
            $valid_email = false;
        }

        if ($valid_email) {

            // check if user already exists
            $user_exists = Databasecontrols::checkDataExists('users', ["id","email","password","login_status","permissions"], 'email', ["email"=>$email]);

            if (isset($user_exists['data']['email'])) {

                // do a check to see if user is already logged in
                if ($user_exists['data']['login_status'] === 'true') {
                    $response = array(
                        'status'=> array(
                            'code'=> 400,
                            'message'=> 'error'
                        ),
                        'info'=> array(
                            'message'=> 'You are already logged in via another device or browser. Please try again'
                        )
                    );

                    exit(json_encode($response));
                }

                // verify the users password against stored hash
                if (password_verify($password, $user_exists['data']['password'])) {

                    // update users account information with last login information, browser used & login status
                    $date = generate_current_date();
                    $browser_info = new Browser();
                    $browser_details = array(
                        'browser_name' => $browser_info->getBrowser(),
                        'browser_version'=> $browser_info->getVersion(),
                        'platform' => $browser_info->getPlatform(),
                        'user_agent'=> $_SERVER['HTTP_USER_AGENT']
                    );

                    // fields to update in DB
                    $fields = array(
                        'last_login_date' => $date['readable_date_db'],
                        'login_status' => 'true',
                        "device_browser_info[JSON]"=> $browser_details
                    );

                    // where clause for our DB request
                    $where = array(
                        'email'=>$email
                    );

                    // do an update on validated users row in database
                    $update_login_times = Databasecontrols::updateRow('users', $fields, $where);

                    if ($update_login_times['data']) {

                        // start session();
                        sec_session_start();

                        // set sessions for authenticated user
                        $_SESSION['uem'] = $email;
                        $_SESSION['adm_authtoken'] = $CSRFtoken;

                        // return success login response
                        $response = array(
                            'status'=> array(
                                'code'=> 200,
                                'message'=> 'success'
                            ),
                            'info'=> array(
                                'message'=> 'user logged in successfully. password verified',
                                'user_info'=>array(
                                    'permissions'=>$user_exists['data']['permissions'],
                                    'email'=>$user_exists['data']['email'],
                                    'id'=>$user_exists['data']['id']
                                ),
                                'brswr'=>$browser_details,
                                'fields'=> $fields
                            )
                        );
                    } else {
                        $response = array(
                            'status'=> array(
                                'code'=> 400,
                                'message'=> 'error'
                            ),
                            'info'=> array(
                                'message'=> 'Error logging in. Please try again. If problem persists contact your developer'
                            )
                        );
                    }
                } else {
                    // return login error

                    $response = array(
                        'status'=> array(
                            'code'=> 400,
                            'message'=> 'error'
                        ),
                        'info'=> array(
                            'message'=> 'credentials entered do not match. Please try again'
                        )
                    );
                }
            } else {

                // // NOTE: entered email doesnt exist in admin user database

                $response = array(
                    'status'=> array(
                        'code'=> 400,
                        'message'=> 'error'
                    ),
                    'info'=> array(
                        'message'=> 'credentials entered do not match. Please try again',
                        'user'=> $user_exists
                    )
                );
            }
        } else {

            // // NOTE: email not valid

            $response = array(
                'status'=> array(
                    'code'=> 400,
                    'message'=> 'error'
                ),
                'info'=> array(
                    'message'=> 'Invalid email entered'
                )
            );
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
