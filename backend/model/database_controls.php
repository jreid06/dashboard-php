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

    public static function createPluginTable($table_name, $table_columns)
    {
        parent::checkConnection();
        $con = parent::returnConnection();

        $index = 0;
        $table_column_length = count($table_columns);
        $primary_key = '';
        $engine = "ENGINE = InnoDB;";
        $comma = ", ";

        $query = "CREATE TABLE `dashboard`.";
        $query .= "`".$table_name."` (";

        foreach ($table_columns as $key => $value) {
            if (gettype($value) === 'array') {
                foreach ($value as $inner_key => $inner_value) {
                    if ($inner_key === 'auto_inc') {
                        $query .= "`$key` {$table_columns['id']['type']} NOT NULL AUTO_INCREMENT".$comma;
                    }

                    if ($inner_key === 'primary_key' && $inner_value) {
                        $primary_key = "PRIMARY KEY (`$key`)) ";
                    }
                }

                continue;
            }

            $query .= "`$key` $value NOT NULL".$comma;
        }

        $query .= $primary_key.$engine;

        $con->query($query);

        $error = $con->error();
        if ($error[0] === '00000') {
            return [
                'data'=> $con,
                'status'=> 200,
                "query"=>$query,
                "params"=> array(
                    "table_name"=> $table_name,
                    'columns_info'=>$table_columns
                )];
        } elseif ($error[0] !== '00000') {
            return [
                'data'=> $con,
                'status'=> 400,
                'error_array'=> $error,
                "query"=>$query,
                "params"=> array(
                    "table_name"=> $table_name,
                    'columns_info'=>$table_columns
                )];
        }
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

    public static function selectData($tbl, $columns, $where_clause)
    {
        parent::checkConnection();
        $con = parent::returnConnection();

        if ($where_clause) {
            $result = $con->select($tbl, $columns, $where_clause);
        } else {
            $result = $con->select($tbl, $columns);
        }


        $error = $con->error();
        if ($error[0] === '00000') {
            return ['data'=> $result, 'status'=> 200];
        } elseif ($error[0] !== '00000') {
            return ['data'=> $result, 'status'=> 400, 'error_array'=> $error];
        }
    }

    public static function updateRow($tbl, $fields, $where)
    {
        parent::checkConnection();
        $con = parent::returnConnection();

        $update_status = $con->update($tbl, $fields, $where);

        $error = $con->error();
        if ($error[0] === '00000') {
            return ['data'=> $update_status, 'status'=> 200];
        } elseif ($error[0] !== '00000') {
            return ['data'=> $update_status, 'status'=> 400, 'error_array'=> $error];
        }
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
