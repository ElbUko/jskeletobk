<?php

use modelo\PacmanPantalla;
use dao\Consultas;

include_once(\Config::CONSULTAS);

class TblPacPantallasUsr extends Consultas
{
    
    public function cuentaNombre(string $nombre){
        $sql = 'SELECT COUNT(*) FROM pacPantallasUsr where nombre = ?';
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param('s', $nombre);
        $pre->execute();
        $res = $pre->bind_result($num);
        $numReg = null;
        while($pre->fetch()){
            $numReg = $num;
        }
        $pre->close();
        $mysqli->close();
        return $numReg;
    }
    
    public function metePantalla(PacmanPantalla $pacTalla){
        $sql = 'INSERT INTO pacPantallasUsr (nombre, usuario, columnas, filas, pantalla) VALUES (?, ?, ?, ?, ?)';
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $nombre = $pacTalla->getNombre();
        $usuario = $pacTalla->getUsuario();
        $columnas = $pacTalla->getColumnas();
        //TODO -meter fecha del insert en la tabla
        $filas = $pacTalla->getFilas();
        $mapaData = $pacTalla->getMapaData();
        $pre->bind_param('ssiis', $nombre, $usuario, $columnas, $filas, $mapaData);
        return $this->insertaCierraYDevuelveNuevoId($mysqli, $pre);
    }
    
    public function damePantallas(){
        $sql = 'SELECT * FROM pacPantallasUsr';
        //TODO -meter puntuacion y estado en pantallas
        $mysqli = $this->abreConexion();
        $res = $mysqli->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}

?>