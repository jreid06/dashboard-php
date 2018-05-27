<?php

/**
 *
 */

 class Create_navlink
 {
     public $navlink;


     private function init_navlink($sublink)
     {
         // code...
     }
 }

$nav_menu_link = array(
    "nav_prefix"=>bin2hex(random_bytes(6)),
    "nav_title"=> 'main title here',
    "nav_id" => 'nav_',
    "nav_href"=>'https://www.google.co.uk',
    "nav_submenu"=> false,
    "nav_submenu_links"=> array(),
    "nav_meta"=>array(
        'image'=> array(
            "status"=> false,
            "source"=> "n/a"
        ),
        'affiliate'=> array(
            "status"=>false,
            "link"=> "n/a"
        )
    )
);

$sublink = array(
    "nav_title"=> 'sublink title here',
    "nav_id" => 'nav_sub_'.$nav_menu_link['nav_prefix'],
    "nav_href"=>'https://www.google.co.uk'
);
