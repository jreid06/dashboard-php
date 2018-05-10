<?php

use Medoo\Medoo;

/**
 *
 */
class Connect
{
    private static $connection;
    public static $environment = "DEV";

    private static function setConnection()
    {
        switch (self::$environment) {
            case 'DEV':
                // echo "dev environment connection <br><br>";

                $db_details = include 'config.php';
                $local = $db_details['local'];

                $database = new Medoo([
                    'database_type' => $local['type'],
                    'database_name' => $local['database_name'],
                    'server' => $local['host'],
                    'username' => $local['usr'],
                    'password' => $local['pass'],
                    'logging'=> true
                ]);

                self::$connection = $database;

                break;
            case 'STAGING':
                echo "dev environment connection";
                $db_details = include 'config.php';
                $staging = $db_details['staging'];

                $database = new Medoo([
                    'database_type' => $staging['type'],
                    'database_name' => $staging['database_name'],
                    'server' => $staging['host'],
                    'username' => $staging['usr'],
                    'password' => $staging['pass'],
                    'logging'=> true
                ]);

                self::$connection = $database;

                break;
            case 'LIVE':
                echo "dev environment connection";
                $db_details = include 'config.php';
                $live = $db_details['live'];

                $database = new Medoo([
                    'database_type' => $live['type'],
                    'database_name' => $live['database_name'],
                    'server' => $live['host'],
                    'username' => $live['usr'],
                    'password' => $live['pass'],
                    'logging'=> true
                ]);

                self::$connection = $database;

                break;

            default:
                echo "default environment connection";
                break;
        }
    }

    public static function returnConnection()
    {
        return self::$connection;
    }

    public static function checkConnection()
    {
        self::setConnection();
    }
}
