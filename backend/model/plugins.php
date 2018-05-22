<?php

/**
 *
 */
interface plugin_interface
{
    public function init();
    public function addFeature($feature_name, $data);
}


/**
 *
 */
class Plugin implements plugin_interface
{
    private $plugin_id;
    private $plugin_prefix = 'DASHBOARD_PLUGIN_';

    public function __construct($plugin_name)
    {
        $this->plugin_name = $plugin_name;
        $this->date = generate_current_date();
        $this->features = array();
        $this->description = '';
    }

    public function getPluginInfo()
    {
        if ($this->plugin_id) {
            return [ "plugin_id" => $this->plugin_id,
                "plugin_name"=>$this->plugin_name,
                "date_installed" =>$this->date];
        }

        return ["error"=>"plugin hasn't been initialized yet"];
    }

    private function registerPlugin()
    {
        /*
            1. check if plugin has already been registered
                - add the data to the plugin table if it doesnt exist

                - this will hold all the plugin specific data
                - nav plugin e.g
                    - link name, link href, additonal info such as images &&|| icons
        */

        $create_plugin_id = $this->plugin_prefix.bin2hex(random_bytes(10));

        $plugin_exists = Databasecontrols::checkDataExists('plugins', ["id", "name"], 'name', ["name"=>$this->plugin_name]);

        if (isset($plugin_exists['data']['name'])) {
            /*
                // NOTE: plugin table will be same name as plugin name e.g navigation

                - return message to say plugin is already registered.
            */
        }

        // NOTE: add the new plugin data to the plugin table filling in basic fields (id, name, date_installed)
    }

    public function addFeature($feature_name, $data)
    {
        /*
            // NOTE:
            $feature_name / String
            $data / array
        */
        $feature_details = array(
            'feature_name' => $feature_name,
            'data'=> $data
        );

        array_push($this->features, $feature_details);
    }

    public function init()
    {
        $response = array(
            'message'=>"function initalized",
            'plugin'=> array(
                'details'=> $this->getPluginInfo(),
                'features'=> $this->features
            )

        );

        return [json_encode($response), $response];
    }
}
