<?php

use dao\Consultas;
use servicios\Sesion;
use util\Literal;

include_once(Config::CONSULTAS);
include_once(Config::LITERAL);
include_once(Config::SESION);

class PacmanPantallasCtrl{
    private $imgData;
    private $mapadata;
    private $nombre;
    private $filas;
    private $columnas;
    private $usuario;
    private $sesion;
    
    function __construct(){
        $this->sesion = new Sesion();
        $this->consultas = new Consultas();
    }
    
    private function cargaParametros($in){
        $this->imgData = $in[Literal::PARAM_IMG_DATA];
        $this->mapadata = $in[Literal::PARAM_MAPADATA];
        $this->nombre = $in[Literal::PARAM_NOMBRE];
        $this->filas = $in[Literal::PARAM_FILAS];
        $this->columnas = $in[Literal::PARAM_COLUMNAS];
        
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
        if ($this->sesion->estaLogado()){
            $this->usuario = $this->sesion->getUsuarioLogado();            
        } else {
            $this->usuario = $this->sesion->getInvitado();            
        }
    }
    private function trataImagenSubida(){
        //TODO - seguridad a imagen
        return base64_decode(substr($this->imgData,22));
    }
    public function pacMapaNuevo($in){
        $this->cargaParametros($in);
        $this->cargaUsuarioLogado();
        return ['ok'=>$this->nombre, 'id'=>$this->usuario];
        //$this->usuario.' '.$this->columnas.' '.$this->nombre.' '.$this->filas;
        
    } 
}

?>