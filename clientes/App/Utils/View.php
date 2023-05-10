<?php

namespace App\Utils;

class View {

    private static function getContentView($view){
        $file = __DIR__.'/../Resoucers/View/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : "";
    }

    public static function render($view, $vars = []){

        $contetView = self::getContentView($view);
        
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        }, $keys);

        return str_replace($keys, array_values($vars),$contetView);
    }
}