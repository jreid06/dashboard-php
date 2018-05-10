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
    public function __construct($plugin_name)
    {
        $this->plugin_name = $plugin_name;
        $this->date = generate_current_date();
        $this->features = array();
        $this->description = '';
    }

    public function getPluginInfo()
    {
        return [ "plugin_name"=>$this->plugin_name,
            "date_installed" =>$this->date ];
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

        echo json_encode($response);
    }
}
