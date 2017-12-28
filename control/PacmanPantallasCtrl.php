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
        $imgData = $in[Literal::PARAM_IMG_DATA];
        $mapadata = $in[Literal::PARAM_MAPADATA];
        $nombre = $in[Literal::PARAM_NOMBRE];
        $filas = $in[Literal::PARAM_FILAS];
        $columnas = $in[Literal::PARAM_COLUMNAS];
        
        if (!isset($nombre, $filas, $columnas, $mapadata, $imgData)){
            syslog(LOG_INFO, 'alguno no set..');
            return -1;
        }
        $this->imgData = $imgData;
        $this->mapadata = $mapadata;
        $this->nombre = $nombre;
        $this->filas = $filas;
        $this->columnas = $columnas;
        return 0;
    }
    private function trataImagenSubida(){
        //TODO - seguridad a imagen
        return base64_decode(substr($this->imgData,22));
    }
    private function nombreValido(){
        //TODO - seguridad al nombre (solo alfanumerico y asi)
        return true;
    }
    public function pacAltaMapa($in){
        if ($this->cargaParametros($in) == -1) {
            return -1;
        }
        if (!$this->nombreValido()){
            //TODO - responde nombre no valido (o error y valida nombre igual en front)
        }
        if($this->pacmanSrv->nombreNuevo($this->nombre)){
            $creaImg = new CreaGuardaImagen($this->nombre, 10*$this->columnas, 10*$this->filas);
            if ($creaImg->deBase64($this->imgData)){
                $this->pacmanSrv->guardaMapa($this->mapadata, $this->filas, $this->columnas);
                //TODO - responde ok
            } 
            //TODO - responde KO
        } else {
            //TODO - responde nombre existe
        }
    }
    public function pacListaMapas(){
        return $this->pacmanSrv->listaMapas();
    }
}

?>