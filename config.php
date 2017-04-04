<?php


//FICHEROS
$home = dirname(__DIR__).'/public_html';

define('CONTADOR',		$home."/contador.txt");
define('LOGIN',			$home."/control/login.php");
define('PACMAN_LEVELS',	$home."/control/pacmanUsrLevel.php");
define('SESION', 		$home.'/servicios/sesion.php');
define('CONSULTAS', 	$home.'/php/dao/consultas.php');


$eventos = [
	"ping" =>  [
		"control" => [LOGIN, "LoginControl"],
		"params"  => []
	],
	"loga" => [
		"control" => [LOGIN, 'LoginControl'],
		"params"  => ["usr", "pss"]
	],
	"desloga" => [
		"control" => [LOGIN, 'LoginControl'],
		"params"  => []
	]
];


#Localhost
$localhost = 'http://localhost/juegoskeleto/';

#Datos de conexion
$host = 'localhost'; 
$root = 'root'; 
$clave = 'bukobuko'; 
$db = 'prueba1';
define('HOST', 'localhost');
define('ROOT', 'root');
define('CLAVE', 'bukobuko');
define('DB', 'prueba1');

?>