<?php

namespace servicios;

use util\Literal;

class Sesion {
    
    function __construct(){
        session_start();
        if ($this->esNueva()){
            $this->setInvitado($this->crea_invitado());
        }
    }    
    public function esNueva(){
        return !isset($_SESSION[Literal::SES_INVITADO]);
    }
    public function estaLogado(){
        return isset($_SESSION[Literal::SES_USUARIO])
        && $_SESSION[Literal::SES_USUARIO] != -1;
    }
    public function loga($nombreUsuario){
        $_SESSION[Literal::SES_USUARIO] = $nombreUsuario;
    }
    public function desloga(){
        $_SESSION[Literal::SES_USUARIO] = -1;
    }
    public function getUsuarioLogado(){
        return $_SESSION[Literal::SES_USUARIO];
    }
    public function getInvitado(){
        return $_SESSION[Literal::SES_INVITADO];
    }
    public function setInvitado($numeroInvitado){
        $_SESSION[Literal::SES_INVITADO] = $numeroInvitado;
    }
    private function crea_invitado(){
        $archivo = \Config::CONTADOR;
        $recurso = fopen($archivo, "r+");
        $bytes_totales = filesize($archivo);
        $contador = fread($recurso, $bytes_totales);
        $nuevo_contenido = $contador + 1;
        $posicion_actual = ftell($recurso);
        if($posicion_actual == $bytes_totales) {
            // me muevo al byte 0 para sobreescribir el archivo
            fseek($recurso, 0);
        }
        fwrite($recurso, $nuevo_contenido);
        fclose($recurso);
        return 'invitado'.$nuevo_contenido;
    }
}
?>