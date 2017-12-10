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
        $pre->bind_param('ssiis',
            $pacTalla->getNombre(),
            $pacTalla->getUsuario(),
            $pacTalla->getColumnas(),
            $pacTalla->getFilas(),
            $pacTalla->getMapaData());
        return $this->insertaCierraYDevuelveNuevoId($mysqli, $pre);
    }
}

?>