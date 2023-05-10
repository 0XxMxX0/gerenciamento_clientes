<?php

namespace App\Model;

class Client{
    private $id;
    private $name;
    private $email;
    private $telphone;
    private $cpf;

    public function __construct($id,$name,$email,$telphone,$cpf){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->telphone = $telphone;
        $this->cpf = $cpf;
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getTelphone(){
        return $this->telphone;
    }
    public function getCpf(){
        return $this->cpf;
    }
}