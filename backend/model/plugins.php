<?php

/**
 *
 */
class Plugin extends Pluginsetup
{
    public function get_response_history_list()
    {
        return json_encode($this->response_code);
    }

    public function set_description($description)
    {
        try {
            $this->details['description'] = $description;
            $success = array(
                'code'=>200,
                'code_status'=>'success',
                'message'=>'plugin description updated successfully',
                'date'=> parent::generate_current_date()
            );
        } catch (\Exception $e) {
        }
    }

    public function get_plugin_instance()
    {
        return $this;
    }
}


/**
 *
 */
class Pluginsetup extends Projectfunctions
{
    private $plugin_name;
    protected $response_code = array();
    private $plugin_slug;
    private $plugin_id;
    private $plugin_prefix = 'JBRDASHBOARD_PLUGIN_';
    private $table_name;
    private $table_structure;
    private $date;
    private $__init_limit = 1;
    private $__init_count = 0;

    public $details = array(
        'description'=>'',
        'image'=> [
            "plugin_main"=> '',
            "additional"=> []
            ]
    );

    /**
     * @table_name(string)
     *
     * @table_settings(array)
     * key: column name -
     * value: type (int(255), text(1000))
     *
     */
    public function initDatabaseTable($table_name, $table_columns)
    {
        // access settings and get columns and table name
        // get column data types
        // Databasecontrols::createTable();

        $status = Databasecontrols::createPluginTable($table_name, $table_columns);

        return json_encode($status);
    }

    public function initPlugin($settings)
    {
        try {
            if ($this->__init_count === 1) {
                $error = array(
                    'code'=>400,
                    'code_status'=>'error',
                    'message'=>'plugin has already been initialized!!',
                    'date'=> parent::generate_current_date()
                );

                // send back error response to our private variable
                array_push($this->response_code, $error);
                return;
            }

            $this->plugin_name = $settings['plugin_name'];
            $this->plugin_id = $this->plugin_prefix.$settings['plugin_id'];
            $this->plugin_slug = $settings['plugin_slug'];
            $this->table_name = $settings['plugin_table_name'];
            $this->table_structure = $settings['plugin_table_structure'];
            $this->date = parent::generate_current_date();

            $this->__init_count ++;

            $response = array(
                'message'=>"function initalized",
                'plugin'=> array(
                    'details'=> $this->getPluginInfo()
                )
            );

            $success = array(
                'code'=>200,
                'code_status'=>'success',
                'message'=>'plugin initialized successfully',
                'date'=> parent::generate_current_date()
            );

            // send back error response to our private variable
            array_push($this->response_code, $success);
        } catch (\Exception $e) {
            $response = array(
                'message'=>"failed to initalize plugin",
                'error'=> $e
            );
        }

        return [json_encode($response), $response];
    }

    public function getPluginInfo()
    {
        if ($this->plugin_id) {
            $plugin_info = array(
                "plugin_id" => $this->plugin_id,
                "plugin_name"=>$this->plugin_name,
                "date_installed" =>$this->date,
                "plugin_table_name" =>$this->table_name,
                "plugin_table_structure"=>$this->table_structure,
                "details"=>$this->details
            );

            return json_encode($plugin_info);
        }

        return ["error"=>"plugin hasn't been initialized yet"];
    }

    public function registerPlugin()
    {
        /*
            1. check if plugin has already been registered
                - add the data to the plugin table if it doesnt exist

                - this will hold all the plugin specific data
                - nav plugin e.g
                    - link name, link href, additonal info such as images &&|| icons
        */

        $plugin_exists = Databasecontrols::checkDataExists('plugins', ["id", "plugin_name"], 'plugin_name', ["plugin_name"=>$this->plugin_name]);

        if (isset($plugin_exists['data']['plugin_name'])) {
            /*
                // NOTE: plugin table will be same name as plugin name e.g navigation
            */

            $response = array(
                'message'=>"plugin has already been created. Visit dashboard UI to use plugin"
            );

            $success = array(
                'code'=>300,
                'code_status'=>'warning',
                'message'=>'plugin already registered',
                'date'=> parent::generate_current_date()
            );

            // send back success response to our private array of plugin interactions
            array_push($this->response_code, $success);
        } else {
            $fields = array(
                "plugin_id" => $this->plugin_id,
                "plugin_slug" => $this->plugin_slug,
                "plugin_name" => $this->plugin_name,
                "plugin_json_data" => $this->getPluginInfo(),
                "date_installed" =>$this->date['date_style_db'],
                "plugin_table_name" =>$this->table_name,
            );

            // create plugin entry in database
            $plugin_registered = Databasecontrols::insert('plugins', $fields);

            $response = array(
                'message'=>"plugin registered successfully. register plugin in our plugins table"
            );

            $success = array(
                'code'=>200,
                'code_status'=>'success',
                'message'=>'plugin registered successfully',
                'date'=> parent::generate_current_date(),
                'plugin_registered'=>$plugin_registered
            );

            // send back success response to our private array of plugin interactions
            array_push($this->response_code, $success);
        }

        // NOTE: add the new plugin data to the plugin table filling in basic fields (id, name, date_installed)
    }
}
