<?php
namespace dao;

use Config;

include_once(dirname(__DIR__)."../../config.php");

class Consultas {
    private $host;
    private $root;
    private $clave;
    private $db;
    
    public function __construct(){
        $config = new Config();
        $this->$host = $config->host;
        $this->$root = $config->root;
        $this->$clave = $config->clave;
        $this->$db = $config->db;
    }
    
    private function abreConexion(){
        $conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
        if (!$conn){
            die('Could not connect: ' . mysql_error());
        }
        return $conn;        
    }    
    private function abrePrepared($conn, $sql){
        return mysqli_prepare($conn, $sql);
    }
    private function cierraPreparedYConexion($pre, $conn){
        mysqli_stmt_close($pre);
        mysqli_close($conn);        
    }    
    
    public function findUsers($usr){
        $conn = $this->abreConexion();
        $sql = "SELECT * FROM usuarios where username like ?";
        $prepared = $this->abrePrepared($conn, $sql);        
        
        $registros = array();
        mysqli_stmt_bind_param($pre, "s", $usr);					# indico los datos a reemplazar con su tipo
        mysqli_stmt_execute($pre);									# Ejecuto la consulta
        mysqli_stmt_bind_result($pre, $id, $username, $password);		# asocio los nombres de campo a nombres de variables
        while(mysqli_stmt_fetch($pre)) {							# Capturo los resultados y los guardo en un array
            $registros[] = array('id'=>$id,
                'username'=>$username,
                'password'=>$password);
        }
        mysqli_stmt_close($pre);									# Cierro la consulta
        mysqli_close($conn);										# Cierro la conexion
        return $registros;											# Devuelvo los usuarios
    }
    
    function meteUsuario($usr, $pass){
        global $host, $root, $clave, $db;
        $conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
        if (!$conn){
            die('Could not connect: ' . mysql_error());
        }
        $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
        $pre = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($pre, "ss", $usr, $pass);
        mysqli_stmt_execute($pre);
        $nuevo_id = mysqli_insert_id($conn);
        mysqli_stmt_close($pre);
        mysqli_close($conn);										# Cierro la conexion
        return $nuevo_id;
    }
}

