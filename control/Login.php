<?php
use dao\Consultas;
use servicios\Sesion;
use util\Literal;

include_once(Config::CONSULTAS);
include_once(Config::LITERAL);
include_once(Config::SESION);

class LoginControl {

	private $usr;
	private $invitado;
	private $pass;
	private $sesion;
	private $consultas;
	private $loginValido;
	private $respuesta;
	
	function __construct(){
        $this->sesion = new Sesion();
        $this->invitado = $this->sesion->getInvitado();
        $this->consultas = new Consultas();
	    $this->respuesta = [
	        "login"     => false,
	        "user"      => "",
	        "popup"     => false,
	        "popupMsg"  => ""
	    ];
	}	
	
	private function cargaRespuesta($login, $usr, $popup, $popupMsg){
	    $this->respuesta['login'] = $login;
	    $this->respuesta["user"] = $usr;
	    $this->respuesta['popup'] = $popup;
	    $this->respuesta['popupMsg'] = $popupMsg;	    
	}
	
	private function cargaRespuestaPingLogado(){
	    $this->cargaRespuesta(true, $this->usr, false, "");
	}
	private function cargaRespuestaPingNoLogado(){
	    $this->cargaRespuesta(false, $this->invitado, false, "");
	}
	private function cargaRespuestaNuevoUsuario(){
	    $this->cargaRespuesta(true, $this->usr, true, Literal::MSG_BIENVENIDA_PRIMERA);
	}
	private function cargaRespuestaLoginOk(){
	    $this->cargaRespuesta(true, $this->usr, true, Literal::MSG_BIENVENIDA_LOGIN);
	}
	private function cargaRespuestaPasswdError(){
	    $this->cargaRespuesta(false, $this->invitado, true, Literal::MSG_PASSWORD_ERRONEO);
	}
	private function cargaRespuestaError(){
	    $this->cargaRespuesta(false, $this->invitado, true, Literal::MSG_ERROR_BBDD);
	}
	private function cargaRespuestaLogout(){
	    $this->cargaRespuesta(false, $this->invitado, true, Literal::MSG_HASTA_PRONTO);
	}
	

	
	/**
	 * Funcion usada para conocer chequear el estado desde el front.
	 * Saber si hay alguien ya logado o se trata de un invitado 
	 */
	public function ping(){
	    if ($this->sesion->estaLogado()){
	        $this->usr = $this->sesion->getUsuarioLogado();
	        $this->cargaRespuestaPingLogado();
	    } else {
    	    $this->cargaRespuestaPingNoLogado(); 
	    } 
		return $this->respuesta;
	}
	
	   
	/**
	 * Function usada para el login. Casos: 
	 *     1) nuevo usuario (sign in)  
	 *     2) usuario registrado (login)
	 *     3) usuario existe y no es la contraseña
	 *     4) error en bbdd
	 * @param el array de parametros
	 */
	public function loga($in){
	    if ($this->sesion->estaLogado()){
	        return -1;
	    }
	    $this->cargaParametrosDeLogin($in);
	    $registros = $this->consultas->findUsers($this->usr);
	    if ($registros==null){
            $this->trataCrearUsuario();
	    } else {
            $this->compruebaUsuario($registros);
	    }
        
        if ($this->loginValido){
            $this->sesion->loga($this->usr);
        }
        return $this->respuesta;
	}	
	
	private function cargaParametrosDeLogin($in){
	    $usr = $in[Literal::PARAM_USR];
	    $pass = $in[Literal::PARAM_PSSWD];
	    if (!isset($usr, $pass)){
	        return -1;
	    }
        $this->usr = $usr;
        $this->pass = $pass;
	}

	private function trataCrearUsuario(){
	    $id = $this->consultas->meteUsuario($this->usr,$this->pass);
	    if ($id != 0) {
	        $this->loginValido = true;
	        $this->cargaRespuestaNuevoUsuario();
	    } else {
	        $this->cargaRespuestaError();
	    }
	}
	
	private function compruebaUsuario($registros){
	    if ($this->pass == $registros[0]['password']){
	        $this->loginValido = true;
	        $this->cargaRespuestaLoginOk();
    	    return $id;
	    } else {
	        $this->cargaRespuestaPasswdError();
	    }
	}
		
	
	/**
	 * Funcion para cerrar sesion. 
	 * Genera un nuevo invitado
	 */
	public function desloga(){
	    if ($this->sesion->estaLogado()){
            $this->cargaRespuestaLogout();
            $this->sesion->desloga();
            return $this->respuesta;
	    }
        return -1;
	}

}

?>
