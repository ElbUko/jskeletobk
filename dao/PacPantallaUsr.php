<?php

use modelo\PacmanPantalla;

class PacPantallaUsr extends Consultas
{
    
    public function compruebaNombre(string $nombre){
        $sql = "SELECT COUNT(*) FROM pacPantallasUsr (nombre) VALUES (?)";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("s", $nombre);
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

