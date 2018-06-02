<?php
    // session_start();
    include '../model/dbconnect.php';

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



    if (isset($_POST['form_data'])) {
        $user_data = $_POST['form_data'];
        $email = $user_data['email'];
        $password = $user_data['password'];

        // validate email again
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid_email = true;
        }

        if (isset($valid_email)) {

            // check if user already exists
            $user_exists = Databasecontrols::checkDataExists('users', ["id","admin_id", "email","password","login_status","permissions", "sessions_array"], 'email', ["email"=>$email]);

            if (isset($user_exists['data']['email'])) {

                // verify the users password against stored hash
                if (password_verify($password, $user_exists['data']['password'])) {

                    // update users account information with last login information, browser used & login status
                    $date = generate_current_date();
                    $browser_info = $GLOBALS['browser_info'];

                    // browser details array
                    $browser_details = array(
                        'browser_name' => $browser_info->getBrowser(),
                        'browser_version'=> $browser_info->getVersion(),
                        'platform' => $browser_info->getPlatform(),
                        'user_agent'=> $_SERVER['HTTP_USER_AGENT']
                    );

                    // standard fields to update in DB
                    $fields = array(
                        'last_login_date' => $date['readable_date_db'],
                        'last_login_ip' => $GLOBALS['ip_address_data']['public_ip'],
                        'login_status' => 'true',
                        "device_browser_info[JSON]"=> $browser_details
                    );

                    // where clause for our DB request
                    $where = array(
                        'email'=>$email
                    );

                    // NOTE: conditional only for accounts created before admin_id was added
                    // check if admin id exists in database.

                    if (!$user_exists['data']['admin_id']) {
                        // create an admin_id
                        $admin_id = $GLOBALS['admin_user_prefix'].bin2hex(random_bytes(10));

                        // add extra field to fields array for updating data
                        $fields['admin_id'] = $admin_id;
                    }

                    // do an update on validated users row in database
                    $update_login_session_times = Databasecontrols::updateRow('users', $fields, $where);

                    if ($update_login_session_times['data']) {

                        // start session();
                        sec_session_start();

                        // set sessions for authenticated user
                        $_SESSION['uem'] = $email;
                        $_SESSION['adm_authtoken'] = $CSRFtoken;

                        // init sessions log array
                        $ip_session_data = $GLOBALS['ip_address_data'];
                        $ip_session_data['browser'] = $browser_info->getBrowser();
                        $ip_session_data['device'] = isset($bot) ? 'bot' : $device;
                        $ip_session_data['os'] =  isset($bot) ? 'bot' : $osInfo['name'];

                        // check if sessions_column is not empty
                        if ($user_exists['data']['sessions_array']) {
                            $sessions_data_array = json_decode($user_exists['data']['sessions_array'], true);
                            $sesh_length = count($sessions_data_array);

                            $incorrect_match_count = 0;

                            // make sure its not an empty array for sessions
                            if ($sesh_length > 0) {
                                for ($i=0; $i < $sesh_length; $i++) {
                                    if ($sessions_data_array[$i]['public_ip'] === $ip_session_data['public_ip']) {

                                        // check if browsers/device/OS && HOSTIP match
                                        if ($sessions_data_array[$i]['browser'] === $ip_session_data['browser'] && $sessions_data_array[$i]['device'] === $ip_session_data['device'] && $sessions_data_array[$i]['os'] === $ip_session_data['os'] && $sessions_data_array[$i]['hostname'] === $ip_session_data['hostname']) {

                                            // update the token
                                            $sessions_data_array[$i]['adm_authtoken'] = $_SESSION['adm_authtoken'];
                                        } else {
                                            $incorrect_match_count += 1;
                                        }
                                    } else {
                                        $incorrect_match_count += 1;
                                    }
                                }

                                // re-add the updated $ip_session_data to the $sessions_data_array ARRAY
                                $ip_session_data['ip_count'] = 1;
                                $ip_session_data['adm_authtoken'] = $_SESSION['adm_authtoken'];


                                array_push($sessions_data_array, $ip_session_data);
                            } else {
                                // update sessions_array column now session has been created successfully

                                $ip_session_data['ip_count'] = 1;
                                $ip_session_data['adm_authtoken'] = $_SESSION['adm_authtoken'];


                                array_push($sessions_data_array, $ip_session_data);
                            }
                        } else {
                            /*
                                - NOTE: ELSE
                                    - CREATE new session assoc array with necessary data
                            */

                            // update sessions_array column now session has been created successfully

                            $ip_session_data['ip_count'] = 1;
                            $ip_session_data['adm_authtoken'] = $_SESSION['adm_authtoken'];

                            // add device specific data to array
                            $ip_session_data['device'] = isset($bot) ? 'bot' : $device;
                            $ip_session_data['os'] =  isset($bot) ? 'bot' : $osInfo['name'];

                            // place new session data into an array as its just an object (assoc array)
                            $ip_session_data = [$ip_session_data];
                        }


                        // end login script here in this conditional if an existing $sessions_data_array pulled from DB exists
                        if (isset($sessions_data_array)) {
                            $session_field = array(
                                "sessions_array[JSON]" => $sessions_data_array
                            );

                            $session_log = Databasecontrols::updateRow('users', $session_field, $where);

                            // return success login response
                            $response = array(
                                'status'=> array(
                                    'code'=> 200,
                                    'message'=> 'success'
                                ),
                                'info'=> array(
                                    'message'=> 'user logged in successfully. email & password verified',
                                    'token'=> $_SESSION['adm_authtoken'],
                                    'brswr'=>$browser_details,
                                    'session_data'=> $sessions_data_array
                                )
                            );

                            exit(json_encode($response));
                        }

                        // create a new array with login session information and save it in database as this is users first login

                        $session_field = array(
                            "sessions_array[JSON]" => $ip_session_data
                        );

                        $session_log = Databasecontrols::updateRow('users', $session_field, $where);

                        // return success login response
                        $response = array(
                            'status'=> array(
                                'code'=> 200,
                                'message'=> 'success'
                            ),
                            'info'=> array(
                                'message'=> 'user logged in successfully. email & password verified',
                                'token'=> $_SESSION['adm_authtoken'],
                                'brswr'=>$browser_details,
                                'new_session'=> $ip_session_data
                            )
                        );


                    // //
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
