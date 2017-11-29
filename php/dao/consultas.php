<?php
//include_once(Config::conifg);

class Consultas {
    
    private $host = 'localhost';
    private $root = 'root';
    private $clave = 'bukobuko';
    private $db = 'prueba1';
    /*
    function __construct(){
        $this->db = DB;
        $this->clave = CLAVE;
        $this->host = HOST;
        $this->root = ROOT;
    }
    */
    private function abreConexion(){
        $con =  mysqli_connect($this->host, $this->root, $this->clave, $this->db);
    	if (!$con){
    		die('Could not connect: ' . mysql_error());
    	}
    	return $con;
    }
    
#############################################################
##########				LOGIN			#####################
#############################################################

    public function findUsers($usr){
    	$conn = $this->abreConexion();
    	$registros = array();
    	$sql = "SELECT * FROM usuarios where username like ?";
    	$pre = mysqli_prepare($conn, $sql);
    	mysqli_stmt_bind_param($pre, "s", $usr);
    	mysqli_stmt_execute($pre);
    	mysqli_stmt_bind_result($pre, $id, $username, $password);
    	while(mysqli_stmt_fetch($pre)) {
    	   $registros[] = array('id'=>$id,
    						'username'=>$username,
    						'password'=>$password);
    	}
    	mysqli_stmt_close($pre);
    	mysqli_close($conn);
    	return $registros;
    }

    public function meteUsuario($usr, $pass){
    	$conn = $this->abreConexion();
    	$sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    	$pre = mysqli_prepare($conn, $sql);
    	mysqli_stmt_bind_param($pre, "ss", $usr, $pass);
    	mysqli_stmt_execute($pre);
    	$nuevo_id = mysqli_insert_id($conn);
    	mysqli_stmt_close($pre);
    	mysqli_close($conn);
    	return $nuevo_id;
    }
}
/*create table usuarios(
    -> id int(11) not null auto_increment primary key,
    -> username varchar(20) not null,
    -> password varchar(20)) engine= innodb;
 */
/*
function damePuntos($juego, $modo, $cantidad){
	global $host, $root, $clave, $db;
	$conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
	if (!$conn){
		die('Could not connect: ' . mysql_error());
	}
	$registros = array();
	$sql = "SELECT * FROM puntos WHERE juego LIKE ? AND modo LIKE ? ORDER BY puntos DESC LIMIT ?";		# Preparo la sentencia
	$pre = mysqli_prepare($conn, $sql);							# Preparo la consulta
	mysqli_stmt_bind_param($pre, "ssi", $juego, $modo, $cantidad);					# indico los datos a reemplazar con su tipo
	mysqli_stmt_execute($pre);									# Ejecuto la consulta
	mysqli_stmt_bind_result($pre, $id, $juego, $modo, $jugador, $puntos);		# asocio los nombres de campo a nombres de variables
	while(mysqli_stmt_fetch($pre)) {							# Capturo los resultados y los guardo en un array
	$registros[] = array('id'=>$id,
						'juego'=>$juego,
						'modo'=>$modo,
						'usuario'=>$jugador,
						'puntos'=>$puntos);
	}
	mysqli_stmt_close($pre);									# Cierro la consulta
	mysqli_close($conn);										# Cierro la conexion
	return $registros;											# Devuelvo los usuarios
}

function metePuntos($juego, $modo, $jugador, $puntos){
	global $host, $root, $clave, $db;
	$conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
	if (!$conn){
		die('Could not connect: ' . mysql_error());
	}
	$sql = "INSERT INTO puntos (juego, modo, usuario, puntos) VALUES (?, ?, ?, ?)";
	$pre = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($pre, "sssi", $juego, $modo, $jugador, $puntos);
	mysqli_stmt_execute($pre);
	$nuevo_id = mysqli_insert_id($conn);
	mysqli_stmt_close($pre);
	mysqli_close($conn);										# Cierro la conexion
	return $nuevo_id;
}


/*create table puntos(
    -> id int(11) not null auto_increment primary key,
    -> juego varchar(20) not null,
    -> modo varchar(20),
    -> usuario varchar(25) not null,
    -> puntos int(12) not null) engine= innodb;
 */

#######################################################################################
##########				PACMAN			###############################
############################################################################
/*
function damePantallas(){
	global $host, $root, $clave, $db;
	$conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
	if (!$conn){
		die('Could not connect: ' . mysql_error());
	}
	$registros = array();
	$sql = "SELECT * FROM pacPantallasUsr ORDER BY puntuacion DESC";		# Preparo la sentencia
	$pre = mysqli_prepare($conn, $sql);							# Preparo la consulta
	//mysqli_stmt_bind_param($pre, "i", $puntuacion);					# indico los datos a reemplazar con su tipo
	mysqli_stmt_execute($pre);									# Ejecuto la consulta
	mysqli_stmt_bind_result($pre, $id, $pantalla, $nombre, $usuario, $filas, $columnas, $ciclico, $puntuacion);		# asocio los nombres de campo a nombres de variables
	while(mysqli_stmt_fetch($pre)) {							# Capturo los resultados y los guardo en un array
	$registros[] = array('id'=>$id,
						'pantalla'=>$pantalla,
						'nombre'=>$nombre,
						'usuario'=>$usuario,
						'filas'=>$filas,
						'columnas'=>$columnas,
						'ciclico'=>$ciclico,
						'puntuacion'=>$puntuacion );
	}
	mysqli_stmt_close($pre);									# Cierro la consulta
	mysqli_close($conn);										# Cierro la conexion
	return $registros;											# Devuelvo los usuarios
}

function damePantallaPorId($id){
	$conn = mysqli_connect(HOST, ROOT, CLAVE, DB);		# Abro conexion con la BBDD
	$registros = array();
	$sql = "SELECT * FROM pacPantallasUsr WHERE id = '$id'";		# Preparo la sentencia
	$pre = mysqli_prepare($conn, $sql);							# Preparo la consulta
	//mysqli_stmt_bind_param($pre, "i", $puntuacion);					# indico los datos a reemplazar con su tipo
	mysqli_stmt_execute($pre);									# Ejecuto la consulta
	mysqli_stmt_bind_result($pre, $id, $pantalla, $nombre, $usuario, $filas, $columnas, $ciclico, $puntuacion);		# asocio los nombres de campo a nombres de variables
	while(mysqli_stmt_fetch($pre)) {							# Capturo los resultados y los guardo en un array
	$registros[] = array('id'=>$id,
						'pantalla'=>$pantalla,
						'nombre'=>$nombre,
						'usuario'=>$usuario,
						'filas'=>$filas,
						'columnas'=>$columnas,
						'ciclico'=>$ciclico,
						'puntuacion'=>$puntuacion );
	}
	mysqli_stmt_close($pre);									# Cierro la consulta
	mysqli_close($conn);										# Cierro la conexion
	return $registros;											# Devuelvo los usuarios
}


function metePantalla($pantalla, $nombre, $usuario, $filas, $columnas){
	global $host, $root, $clave, $db;
	$conn = mysqli_connect($host, $root, $clave, $db);		# Abro conexion con la BBDD
	if (!$conn){
		die('Could not connect: ' . mysql_error());
	}
	$sql = "INSERT INTO pacPantallasUsr (pantalla, nombre, usuario, filas, columnas) VALUES (?, ?, ?, ?, ?)";
	$pre = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($pre, "sssii", $pantalla, $nombre, $usuario, $filas, $columnas);
	mysqli_stmt_execute($pre);
	$nuevo_id = mysqli_insert_id($conn);
	mysqli_stmt_close($pre);
	mysqli_close($conn);										# Cierro la conexion
	return $nuevo_id;
}

function editaPantalla($id, $pantalla, $nombre, $filas, $columnas){
	$conn = mysqli_connect(HOST, ROOT, CLAVE, DB);		# Abro conexion con la BBDD
	$sql = "UPDATE pacPantallasUsr set pantalla=?, nombre=?, filas=?, columnas=? WHERE id = '$id'";
	$pre = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($pre, "ssii", $pantalla, $nombre, $filas, $columnas);
	mysqli_stmt_execute($pre);
	$nuevo_id = mysqli_insert_id($conn);
	mysqli_stmt_close($pre);
	mysqli_close($conn);										# Cierro la conexion
	return $nuevo_id;
}

function borraPantalla($id, $nombre){
	$conn = mysqli_connect(HOST, ROOT, CLAVE, DB);		# Abro conexion con la BBDD
	$query = "DELETE FROM pacPantallasUsr WHERE id = '$id'";
	$resul = mysqli_query($conn, $query) or die(mysql_error());   
	mysqli_close($conn);										# Cierro la conexion
	return $resul;
}
/*
create table pacPantallasUsr(
    -> id int(11) not null auto_increment primary key,
    -> pantalla varchar(600) not null,
    -> usuario varchar(25) not null,
    -> columnas int(3) not null,
    -> ciclico boolean,
    -> puntuacion int(3));
*/
?>