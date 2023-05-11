<?php

namespace App\Model;
use \App\Model\Connect;


class ClientDao{

    public static function create(Client $client){
        $sql = "INSERT INTO client (Name, Email, TelPhone, Cpf) VALUES (?,?,?,?)";

        $insert = Connect::getConn()->prepare($sql);
        $insert->bindvalue(1, $client->getName());
        $insert->bindvalue(2, $client->getEmail());
        $insert->bindvalue(3, $client->getTelphone());
        $insert->bindvalue(4, $client->getCpf());
        $insert->execute();
    }

    public function read($id){

        if($id == ""){
            $sql = "SELECT *
                    FROM client";
        } else {
            $sql = "SELECT *
                    FROM client 
                    WHERE Id_Client = $id";
        }

        $select = Connect::getConn()->prepare($sql);
        $select->execute();

        if($select->rowCount() > 0){
            $resultado = $select->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;  
        } else {
            return [];
        }
    }
    public function update(Client $client){
        $sql = "UPDATE client SET Name = ?, Email = ?, Telphone = ?, Cpf = ? WHERE Id_Client = ?";

        var_dump($client->getId());

        $update = Connect::getConn()->prepare($sql);
        $update->bindvalue(1, $client->getName());
        $update->bindvalue(2, $client->getEmail());
        $update->bindvalue(3, $client->getTelphone());
        $update->bindvalue(4, $client->getCpf());
        $update->bindvalue(5, $client->getId());
        $update->execute();
    }
    public function delete($id){
        $sql = "DELETE FROM client WHERE Id_Client = $id";

        $delete = Connect::getConn()->prepare($sql);
        $delete->execute();
    }
}