<?php
include_once(SESION);
include_once(CONSULTAS);

class LoginControl {

	//MODELO SALIDA
	private $r;
	function __construct(){
		$this->r = [
	        "login"     => false,
	        "user"      => "",
	        "popup"     => false,
	        "popupMsg"  => ""
	    ];
	}

	//METODOS
	function desloga(){
		$sesion = new Sesion();
		$this->r['user'] = $sesion->cierra_sesion();
		return $this->r;
	}

	function ping(){
		$sesion = new Sesion();
		$sesion->abre_sesion();
		$this->r["user"] = $sesion->usuario_logado();
		$this->r["login"] = !$sesion->es_invitado();
		return $this->r;
	}

	function loga($in){
		$usr = $in['usr'];
		$pass = $in['pss'];
		
		if (isset($usr, $pass)){
			$registros = findUsers($usr);
			if (count($registros) == 0) {
				//Creacion nuevo usuario
				$id = meteUsuario($usr,$pass);
				if ($id != 0) {
					$this->r['login'] = true;
					$this->r['popup'] = true;
					$this->r['popupMsg'] = "Bienvenido a Juegoskeleto!";
				}
				else {
					$this->r['popup'] = true;
					$this->r['popupMsg'] = "Hubo un problema en la insercion en nuestra base de datos";	
				}
			}
			else {
				//Comprobacion contraseña
				if (($pass == $registros[0]['password'])){
					$this->r['login'] = true;
					$id = $registros[0]['id'];
				}
				else {
					$this->r['popup'] = true;
					$this->r['popupMsg'] = "El usuario existe y esta no es la clave guardada";
				}
			}
			
			if ($this->r['login']){
				$this->r["user"] = $usr;
				$sesion = new Sesion();
				$sesion->loga($id);
			}
			return $this->r;
		}
		else {
			return -1;
		}
	}
}

?>
