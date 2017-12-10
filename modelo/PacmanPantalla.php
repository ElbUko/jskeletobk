<?php
namespace modelo;

class PacmanPantalla
{
    private $nombre;
    private $usuario;
    private $filas;
    private $columnas;
    private $mapaData;

    public function __construct(){}
    public static function conParametros($nombre, $usuario, $filas, $columnas, $mapadata){
        $obj = new PacmanPantalla();
        $obj->nombre = $nombre;
        $obj->usuario = $usuario;
        $obj->filas = $filas;
        $obj->columnas = $columnas;
        $obj->mapadata = $mapadata;
        return $obj;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function getFilas(){
        return $this->filas;
    }
    public function getColumnas(){
        return $this->columnas;
    }
    public function getMapaData(){
        return $this->mapaData;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setFilas($filas){
        $this->filas = $filas;
    }
    public function setColumnas($columnas){
        $this->columnas = $columnas;
    }
    public function setMapaData($mapaData){
        $this->mapaData = $mapaData;
    }
}
?>
