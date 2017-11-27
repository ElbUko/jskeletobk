<?php
use servicios\Sesion;
use util\Literal;

include_once(CONSULTAS);
include_once(LITERAL);
include_once(SESION);

class LoginControl {

	private $usr;
	private $pass;
	private $sesion;
	private $loginValido;
	private $respuesta;
	
	function __construct(){
        $this->sesion = new Sesion();
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
	private function  cargaRespuestaDeEstado($login, $usr){
	    $this->cargaRespuesta($login, $usr, false, "");
	}
	private function cargaRespuestaNuevoUsuario($usr){
	    $this->loginValido = true;
	    $this->cargaRespuesta(true, $usr, true, Literal::MSG_BIENVENIDA_PRIMERA);
	}
	private function cargaRespuestaLoginOk($usr){
	    $this->loginValido = true;
	    $this->cargaRespuesta(true, $usr, true, Literal::MSG_BIENVENIDA_LOGIN);
	}
	private function cargaRespuestaPasswdError(){
	    $this->cargaRespuesta(false, "", true, Literal::MSG_PASSWORD_ERRONEO);
	}
	private function  cargaRespuestaError(){
	    $this->cargaRespuesta(false, "", true, Literal::MSG_ERROR_BBDD);
	}
	private function  cargaRespuestaLogout($invitado){
	    $this->cargaRespuesta(false, $invitado, true, Literal::MSG_HASTA_PRONTO);
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

	
	/**
	 * Funcion usada para conocer chequear el estado desde el front.
	 * Saber si hay alguien ya logado o se trata de un invitado 
	 */
	public function ping(){
	    $this->sesion->abre_sesion();
	    $this->cargaRespuestaDeEstado(
	        !$this->sesion->es_invitado(), 
	        $this->sesion->usuario_logado());
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
	    $registros = findUsers($this->usr);
        if (count($registros) == 1){
            $id = $this->compruebaUsuario($registros);
        } else {
            $id = $this->trataCrearUsuario();
        }
        
        if ($this->loginValido){
            $this->sesion->loga($id);
        }
        return $this->respuesta;
	}
	
	
	function compruebaUsuario($registros){
	    if ($this->pass == $registros[0]['password']){
	        $id = $registros[0]['id'];
	        $this->cargaRespuestaLoginOk($id);
    	    return $id;
	    } else {
	        $this->cargaRespuestaPasswdError();
	    }
	}
	
	function trataCrearUsuario(){
	    $id = meteUsuario($this->usr,$this->pass);
	    if ($id != 0) {
	        $this->cargaRespuestaNuevoUsuario();
	    } else {
	        $this->cargaRespuestaError();
	    }
	    return $id;
	}
	
	
	/**
	 * Funcion para cerrar sesion. 
	 * Genera un nuevo invitado
	 */
	public function desloga(){
	    $idInvitado = $this->sesion->cierra_sesion();
	    $this->cargaRespuestaLogout($idInvitado);
        return $this->respuesta;
	}

}

?>
