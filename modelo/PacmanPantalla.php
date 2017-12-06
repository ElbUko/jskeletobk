<?php
namespace modelo;

class PacmanPantalla
{
    private $nombre;
    private $usuario;
    private $filas;
    private $columnas;
    private $mapaData;

    public function __construct($nombre, $usuario, $filas, $columnas, $mapadata){
        $this->nombre = $nombre;
        $this->usuario = $usuario;
        $this->filas = $filas;
        $this->columnas = $columnas;
        $this->mapadata = $mapadata;
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
