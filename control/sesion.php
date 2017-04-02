<?php

function creaSesion(){
	session_start();
	return;
}

function hayUsuario(){
	return isset($_SESSION['usuario']);
}
 function usuarioLogado(){
 	return $_SESSION['usuario'];
 }

function login($user){
	session_start();
	$_SESSION['usuario'] = $user; // creo la sesión 'usuario'
}

function logout(){
	session_start();
	$usr = creaInvitado();
	$_SESSION['usuario'] = $usr;
	return $usr;
}

function creaInvitado(){
	global $localhost;
    $archivo = CONTADOR;
    $recurso = fopen($archivo, "r+");
    $bytes_totales = filesize($archivo);
    $contador = fread($recurso, $bytes_totales);
    $nuevo_contenido = $contador + 1;
    $posicion_actual = ftell($recurso);
    if($posicion_actual == $bytes_totales) {
        // me muevo al byte 0 para sobreescribir el archivo
        fseek($recurso, 0);
    }
    fwrite($recurso, $nuevo_contenido);
    fclose($recurso);
    $usuarioInvitado = "invitado".$nuevo_contenido;
    return $usuarioInvitado;
}

?>