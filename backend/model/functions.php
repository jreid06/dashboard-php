<?php

    function verifyPassword($password_entered, $password_database)
    {
        if (password_verify($password_entered, $password_database)) {
            return true;
        } else {
            return false;
        }
    }


    function object_to_array($object)
    {
        return (array) $object;
    }

    function registerAdmin_postman()
    {
        // save users details in variable
        $usr_data = json_decode(file_get_contents("php://input"));

        // prepare database checks on data
        $exists = Databasecontrols::checkDataExists('users', '*', 'email', ["email"=>$usr_data]);

        //

        return $usr_data;
    }


    function generate_current_date()
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

    function add_size_suffix($size_length, $img_size)
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


    // function was used to update a password that wasnt hashed when adding manually // NOTE function no longer needed
    function updatePassword($con, $pass1)
    {
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password='$pass' WHERE id=6";

        $con->query($query);
        $con->close();
    }


    function format_timestamp($timestamp)
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
