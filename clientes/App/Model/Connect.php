<?php

namespace App\Model;

class Connect{
    private static $instance;

    public static function getConn(){
        if(!isset(self::$instance)){
            self::$instance = new \PDO('mysql:host=localhost;dbname=client;charset=utf8','root','');
        }
        return self::$instance;
    }
}