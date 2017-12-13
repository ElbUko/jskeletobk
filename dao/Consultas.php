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
        $this->host = Config::HOST;
        $this->root = Config::ROOT;
        $this->clave = Config::CLAVE;
        $this->db = Config::DB;
        //TODO - meter aqui el abrir conexion y crear el destructor cerrandola
    }
    
    protected function abreConexion(){
        $mysqli = mysqli_connect($this->host, $this->root, $this->clave, $this->db);
        if (mysqli_connect_errno($mysqli)){
            echo('Tenemos problemas con BBDD');
        }
        return $mysqli;        
    }
    protected function insertaCierraYDevuelveNuevoId($mysqli, $pre){
        $pre->execute();
        $nuevo_id = $pre->insert_id;
        $pre->close();
        $mysqli->close();
        return $nuevo_id;
    }
}

?>