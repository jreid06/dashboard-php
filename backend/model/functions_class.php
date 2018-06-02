<?php

/**
 *
 */
class Projectfunctions
{
    public static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public static function convertToReadableSize($size)
    {
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

    public static function sec_session_start()
    {
        $session_name = 'session_admin';   // Set a custom session name
        $secure = true;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // // Forces sessions to only use cookies.
            // if (ini_set('session.use_only_cookies', 1) === false) {
            //     header("Location: ../../test.php?err=Could not initiate a safe session (ini_set)");
            //     exit();
            // }
            // Gets current cookies params.
            // $cookieParams = session_get_cookie_params();
            // session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
            // Sets the session name to the one set above.
            // session_name($session_name);
            session_start();            // Start the PHP session
            // session_regenerate_id();    // regenerated the session, delete the old one.
    }



    public static function object_to_array($object)
    {
        return (array) $object;
    }

    public static function registerAdmin_postman()
    {
        // save users details in variable
        $usr_data = json_decode(file_get_contents("php://input"));

        // prepare database checks on data
        $exists = Databasecontrols::checkDataExists('users', '*', 'email', ["email"=>$usr_data]);

        //

        return $usr_data;
    }


    public static function generate_current_date()
    {
        $current_date = getdate();
        $timestamp = $current_date[0];
        $month_digit = $current_date['mon'];

        $readable_date = date('d/m/Y H:i:s', $timestamp);
        $readable_date_db = date('Y-m-d H:i:s', $timestamp);
        $time = date('H:i:s', $timestamp);
        $date_now = date('d/m/Y', $timestamp);
        $date_now_db = date('Y-m-d', $timestamp);
        $year = date('Y', $timestamp);
        $month = $current_date['month'];
        $weekday = $current_date['weekday'];
        $day = $current_date['mday'];

        return array(
                'readable_date' => $readable_date,
                'readable_date_db' => $readable_date_db,
                'time' => $time,
                'date_style_uk' => $date_now,
                'date_style_db' => $date_now_db,
                'month' => $month,
                'weekday_txt' => $weekday,
                'month_digit' => $month_digit,
                'year' => $year,
                'timestamp' => $timestamp,
                'day' => $day
            );
    }

    public static function add_size_suffix($size_length, $img_size)
    {
        if ($size_length === 5) {
            # KB e.g 47kb
            return round($img_size, 1) . "KB";
        } elseif ($size_length === 6) {
            # KB e.g 577kb
            return round($img_size, 1) . "KB";
        } elseif ($size_length === 7) {
            # MB
            return round($img_size, 1) . "MB";
        }
    }


    public static function format_timestamp($timestamp)
    {
        $ts = $timestamp;
        $date = new DateTime();

        $date->setTimestamp($ts);
        $year = $date->format('Y');
        $time = $date->format('H:i:s');

        $timeArray = array(
                'year'=> $date->format('Y'),
                'month'=> $date->format('m'),
                'day'=> $date->format('d'),
                'time'=> $date->format('H:i:s'),
                'full_date'=>$date->format('d-m-Y')
            );

        return $timeArray;
    }
}
