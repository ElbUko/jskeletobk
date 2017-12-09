<?php

class PacmanSrv {
   private $consultas;
   
   function __construct(){
       $this->consultas = new Consultas();
   }
   
   public function compruebaNombre(){
       $this->consultas
   }
   
   public function guardaMapa(){
       $this->cargaUsuarioLogado();
   }
   
   private function cargaUsuarioLogado(){
       if ($this->sesion->estaLogado()){
           $this->usuario = $this->sesion->getUsuarioLogado();
       } else {
           $this->usuario = $this->sesion->getInvitado();
       }
   }
}

?>