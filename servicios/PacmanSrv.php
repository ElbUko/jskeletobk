<?php

use servicios\Sesion;
use modelo\PacmanPantalla;

include_once(Config::SESION);
include_once(Config::BEANPACPANT);
include_once(Config::TBLPACPANUSR);

class PacmanSrv {
   private $tblPantallasDao;
   private $sesion;
   private $pacmanPantalla;
   
   function __construct(){
       $this->tblPantallasDao = new TblPacPantallasUsr();
       $this->sesion = new Sesion();
       $this->pacmanPantalla = new PacmanPantalla();
   }
   
   public function nombreNuevo($nombre){
       $this->pacmanPantalla->setNombre($nombre);
       $numReg = $this->tblPantallasDao->cuentaNombre($nombre);
       return $numReg == 0;           
   }
   
   public function guardaMapa($mapadata, $filas, $columnas){
       $this->pacmanPantalla->setUsuario($this->cargaUsuarioLogado());
       $this->pacmanPantalla->setFilas($filas);
       $this->pacmanPantalla->setColumnas($columnas);
       $this->pacmanPantalla->setMapaData($mapadata);
       $this->tblPantallasDao->metePantalla($this->pacmanPantalla);
   }
   
   public function listaMapas(){
       return $this->tblPantallasDao->damePantallas();
   }
   
   private function cargaUsuarioLogado(){
       $usr = '';
       if ($this->sesion->estaLogado()){
           $usr = $this->sesion->getUsuarioLogado();
       } else {
           $usr = $this->usuario = $this->sesion->getInvitado();
       }
       return $usr;
   }
}

?>