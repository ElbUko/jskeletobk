<?php


//FICHEROS
$home = dirname(__DIR__).'/jskeletobk';

define('CONSULTAS', $home.'/php/dao/consultas.php');
define('LOGIN',		$home."/control/login.php");
define('SESION', 	$home.'/control/sesion.php');
define('CONTADOR',	$home."/contador.txt");


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