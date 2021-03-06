<?php
namespace dao;

include_once(\Config::CONSULTAS);

class TblUsuarios extends Consultas
{    
    public function findUsers(String $usr){
        $sql = "SELECT * FROM usuarios where username like ?";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("s", $usr);
        $pre->execute();
        $res = $pre->bind_result($id, $username, $password);
        $registros = array();
        while($pre->fetch()){
            $registros[] = array(
                'id'        => $id,
                'username'  => $username,
                'password'  => $password);
        }
        $pre->close();
        $mysqli->close();
        return $registros;
    }
    
    public function meteUsuario(String $usr, String $pass){
        $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
        $mysqli = $this->abreConexion();
        $pre = $mysqli->prepare($sql);
        $pre->bind_param("ss", $usr, $pass);
        return $this->insertaCierraYDevuelveNuevoId($mysqli, $pre);
    }
    /*
     * create table usuarios(
     *      id int(7) not null auto_increment primary key, 
     *      username varchar(20) not null, 
     *      password varchar(50)
     * ) engine=innodb;
     */  
}

?>