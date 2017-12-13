<?php

use util\Literal;

include_once(Config::CREAIMG);
include_once(Config::LITERAL);
include_once(Config::PACMANSRV);

class PacmanPantallasCtrl{
    private $imgData;
    private $mapadata;
    private $nombre;
    private $filas;
    private $columnas;
    private $pacmanSrv;
    
    function __construct(){
        $this->pacmanSrv = new PacmanSrv();
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
    private function trataImagenSubida(){
        //TODO - seguridad a imagen
        return base64_decode(substr($this->imgData,22));
    }
    public function pacAltaMapa($in){
        $this->cargaParametros($in);
        if ($this->pacmanSrv->nombreNuevo($this->nombre)){
            $this->pacmanSrv->guardaMapa($this->mapadata, $this->filas, $this->columnas);
            $creaImg = new CreaGuardaImagen($this->nombre, 10*$this->columnas, 10*$this->filas);
            $cadena = $creaImg->deBase64($this->imgData);
        }
    }
    public function pacListaMapas(){
        return $this->pacmanSrv->listaMapas();
    }
}

?>