<?php

/**
 * Database main controls class. will be extended by other classes
 */
class Databasecontrols extends Connect
{
    public static function insertMultiple($value='')
    {
        // code...
    }

    public static function insert($tbl, $fields)
    {
        // fields is assosiative array
        parent::checkConnection();
        $con = parent::returnConnection();

        $con->insert($tbl, $fields);

        $error = $con->error();
        if ($error[0] === '00000') {
            return ['data'=> true, 'status'=> 200];
        } elseif ($error[0] !== '00000') {
            return ['data'=> false, 'status'=> 400, 'error_array'=> $error];
        }
    }

    public static function selectRow($value='')
    {
        // code...
    }

    public static function checkDataExists($tbl, $columns, $field, $data)
    {
        parent::checkConnection();
        $con = parent::returnConnection();

        //// NOTE:  select (columns) where field = data
        $result = $con->get($tbl, $columns, [$field=>$data[$field]]);

        $error = $con->error();
        if ($error[0] === '00000') {
            return ['data'=> $result, 'status'=> 200];
        } elseif ($error[0] !== '00000') {
            return ['data'=> $result, 'status'=> 400, 'error_array'=> $error];
        }
    }

    public static function selectMultiple($value='')
    {
        // code...
    }

    public static function updateRow($value='')
    {
        // code...
    }

    public static function updateField($value='')
    {
        // code...
    }

    public static function updateMultiple($value='')
    {
        // code...
    }
}
