<?php

if(!function_exists('get_release')){
    function get_release(){
        $version = @file_get_contents(storage_path().'/app/bugfixer/version.json');
        $version = json_decode($version,true);
        echo $version['subversion'];
    }
}