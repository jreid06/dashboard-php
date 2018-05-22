<?php

// include '../dbconnect.php';

/*
    // NOTE:
    - check whether plugin already exists in database
        - TRUE - load plugin from database settings
        - FALSE - init a new plugin and add it to database plugins table
    - links data will be pulled in dynamically from database.
    - features will be created in this script and will be listed in FRONT end.
    - features will be interactive on front end
*/

$links = array(
    'links'=> array('one', 'two', 'three', 'four')
);

$navigation_plugin = new Plugin('navigation');

$navigation_plugin->addFeature('test', $links);

return $navigation_plugin;
