<?php
namespace control;

use util\Literal;
use servicios\Sesion;

class PacmanPantallasCtrl{
    private $imgData;
    private $mapadata;
    private $nombre;
    private $filas;
    private $columnas;
    private $usuario;
    
    private function cargaParametros($in){
        $this->imgData = $in[Literal::IMG_DATA];
        $this->mapadata = $in[Literal::MAPA_MAPADATA];
        $this->nombre = $in[Literal::NOMBRE];
        $this->filas = $in[Literal::FILAS];
        $this->columnas = $in[Literal::COLUMNAS];
        
        if (!isset($nombre, $filas, $columnas, $mapadata, $imgData)){
            return -1;
        }
        $this->imgData;
        $this->mapadata;
        $this->nombre;
        $this->filas;
        $this->columnas;
    }
    
    private function cargaUsuarioLogado(){
        $sesion = new Sesion();
        $this->usuario = $sesion->usuario_logado();
    }
    private function trataImagenSubida(){
        //TODO - seguridad a imagen
        return base64_decode(substr($this->imgData,22));
    }
    public function pacMapaNuevo($in){
        $this->cargaParametros($in);
        $this->cargaUsuarioLogado();
        
        echo $this->usuario.' '.$this->columnas.' '.$this->nombre.' '.$this->filas;
    } 
}

?>