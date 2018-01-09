<?php

use util\Literal;

include_once(Config::CREAIMG);
include_once(Config::LITERAL);
include_once(Config::PACMANSRV);

class PacmanPantallasCtrl{
    private $id;
    private $imgData;
    private $mapadata;
    private $nombre;
    private $filas;
    private $columnas;
    private $pacmanSrv;
    private $respuesta;
    
    function __construct(){
        $this->pacmanSrv = new PacmanSrv();
        $this->respuesta = [
            "ok"        => false,
            "id"        => '',
            "error"     => ''
        ];
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
    
    private function cargaRespuesta($ok, $id, $error){
        $this->respuesta['ok'] = $ok;
        $this->respuesta['id'] = $id;
        $this->respuesta['error'] = $error;
    }
    private function cargaRespuestaOk(){
        $this->cargaRespuesta(true, $this->id, '');
    }
    private function cargaRespuestaError($error){
        $this->cargaRespuesta(false, '', $error);
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
            $this->cargaRespuestaError('Nombre no valido');
        }
        if($this->pacmanSrv->nombreNuevo($this->nombre)){
            $creaImg = new CreaGuardaImagen($this->nombre, 10*$this->columnas, 10*$this->filas);
            if ($creaImg->deBase64($this->imgData)){
                $this->id = $this->pacmanSrv->guardaMapa($this->mapadata, $this->filas, $this->columnas);
                $this->cargaRespuestaOk();
                //TODO - mirar caso no id (error al guardar)
            } else {
                $this->cargaRespuestaError('Imagen corrupta');
            }
            //TODO - mirar si guardar a pesar de no tener imagen
        } else {
            $this->cargaRespuestaError('Ya existe el nombre');
        }
        return $this->respuesta;
    }
    public function pacListaMapas(){
        $pantallas = $this->pacmanSrv->listaMapas();
        $creaImg = new CreaGuardaImagen("", 0, 0);
        $salida = array();
        for ($i=0; $i<sizeof($pantallas); $i++){
            $pantalla = $pantallas[$i];
            $pantalla['img'] = $creaImg->aBase64($pantalla["nombre"]);
            $salida[] = $pantalla;
        }
        return $salida;
    }
}

?>