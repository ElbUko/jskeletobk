<?php
namespace dao;

use Config;

class Consultas {
    private $host;
    private $root;
    private $clave;
    private $db;
    
    public function __construct(){
        new Config();
        $this->host = Config::host;
        $this->root = Config::root;
        $this->clave = Config::clave;
        $this->db = Config::db;
    }
    
    private function abreConexion(){
        $mysqli = mysqli_connect($this->host, $this->root, $this->clave, $this->db);
        if (mysqli_connect_errno($mysqli)){
            echo('Tenemos problemas con BBDD');
        }
        return $mysqli;        
    }
    
    public function findUsers($usr){
        $sql = "SELECT * FROM usuarios where username like ?";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("s", $usr);
        $pre->execute();
        $res = $pre->bind_result($id, $username, $password);
        $registros = array();
        while($pre->fetch()){
            $registros[] = array(
                'id'        => $id,
                'username'  => $username,
                'password'  => $password);            
        }
        $pre->close();
        $mysqli->close();
        return $registros;
    }
    
    function meteUsuario($usr, $pass){
        $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("ss", $usr, $pass);
        $pre->execute();
        $nuevo_id = $pre->insert_id;
        $pre->close();
        $mysqli->close();
        return $nuevo_id;
    }
}

