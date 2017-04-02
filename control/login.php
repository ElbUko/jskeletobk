<?php
include_once(SESION);
include_once(CONSULTAS);

class LoginControl {

	//MODELO SALIDA
	private $r;
	function __construct(){
		$r = [
	        "login"     => false,
	        "invitado"  => false,
	        "user"      => "",
	        "popup"     => false,
	        "popupMsg"  => ""
	    ];
	}

	//METODOS
	function logout(){
		$r['popup'] = false;
		$r['invitado'] = true;
		$r['user'] = logout();
		return $r;
	}

	function ping(){
		creaSesion();
		if (hayUsuario()){
			$r["user"] = usuarioLogado();
			$r["login"] = true;
		}
		else {
		    $r["user"] = creaInvitado();
		 	$r["invitado"] = true;
		}
		return $r;
	}

	function login($usr, $pass){
		$registros = findUsers($usr);
		if (count($registros) == 0) {
			//Creacion nuevo usuario
			$nuevo_id = meteUsuario($usr,$pass);
			if ($nuevo_id != 0) {
				$r['login'] = true;
				$r['popupMsg'] = "Bienvenido a Juegoskeleto!";
			}
			else {
				$r['popupMsg'] = "Hubo un problema en la insercion en nuestra base de datos";	
			}
		}
		else {
			//Comprobacion contraseña
			if (($pass == $registros[0]['password'])){
				$r['login'] = true;
				$r['popup'] = false;
			}
			else {
				$r['popupMsg'] = "El usuario existe y esta no es la clave guardada";
			}
		}
		
		if ($r['login']){
			$r["user"] = $usr;
			login($usr);
		}
		return $r;		
	}
}

?>
