<?php
namespace dao;

use Config;
use modelo\PacmanPantalla;

class Consultas {
    private $host;
    private $root;
    private $clave;
    private $db;
    
    public function __construct(){
        new Config();
        $this->host = Config::HOST;
        $this->root = Config::ROOT;
        $this->clave = Config::CLAVE;
        $this->db = Config::DB;
    }
    
    private function abreConexion(){
        $mysqli = mysqli_connect($this->host, $this->root, $this->clave, $this->db);
        if (mysqli_connect_errno($mysqli)){
            echo('Tenemos problemas con BBDD');
        }
        return $mysqli;        
    }
    private function ejecutaCierraYDevuelveNuevoId($mysqli, $pre){
        $pre->execute();
        $nuevo_id = $pre->insert_id;
        $pre->close();
        $mysqli->close();
        return $nuevo_id;
    }
    
    public function findUsers(String $usr){
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
    
    public function meteUsuario(String $usr, String $pass){
        $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("ss", $usr, $pass);
        return $this->ejecutaCierraYDevuelveNuevoId($mysqli, $pre);
    }
    
    public function metePantalla(PacmanPantalla $pacTalla){
        $sql = "INSERT INTO pacPantallasUsr (nombre, usuario, columnas, filas, mapadata) VALUES (?, ?, ?, ?, ?)";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("ssiis", 
            $pacTalla->getNombre(), 
            $pacTalla->getUsuario(), 
            $pacTalla->getColumnas(), 
            $pacTalla->getFilas(), 
            $pacTalla->getMapaData());
        return $this->ejecutaCierraYDevuelveNuevoId($mysqli, $pre);
    }
}

