<?php

namespace servicios;

class Sesion {
    function abre_sesion(){
        session_start();
        if (!$this->estaLogado()){
            $_SESSION['usuario'] = -1;
            $this -> crea_invitado();
        }
        return;
    }
    
    function estaLogado(){
        return isset($_SESSION['usuario']);
    }

    function cierra_sesion(){
        session_start();
        $usr = $this -> crea_invitado();
        $_SESSION['usuario'] = -1;
        return $usr;
    }

    function usuario_logado(){
        return ($this->es_invitado())?
            $_SESSION['invitado']:
            $_SESSION['usuario'];
    }

    function es_invitado(){
        return ($_SESSION['usuario']==-1);
    }

    function loga($id){
        session_start();
        $_SESSION['usuario'] = $id;
    }

    private function crea_invitado(){
        $archivo = \Config::contador;
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
        $usuarioInvitado = 'invitado'.$nuevo_contenido;
        $_SESSION['invitado'] = $usuarioInvitado;
        return $usuarioInvitado;
    }
}
?>