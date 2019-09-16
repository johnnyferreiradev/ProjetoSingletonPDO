<?php

    namespace App;

    define('__ROOT__', dirname(dirname(__FILE__)) . "/");

    spl_autoload_register(function ($class){
        $class = str_replace( '\\', '/', $class . ".php");
        $fullClass = __ROOT__. $class;
        if(file_exists($fullClass)){
            require_once( $fullClass );
        }
    });
