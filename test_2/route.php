<?php

class Route 
{
    static function start() {
        $controller = explode("/", $_SERVER['REQUEST_URI']);
        $action = "index";

        $controller_name = "controller_" . $controller[1] . ".php";
        $model_name = "model_" . $controller[1] . ".php";

        if(file_exists($model_name)){
            include $model_name;
        }
        
        if(file_exists($controller_name)){
            include $controller_name;
        }
    }
}