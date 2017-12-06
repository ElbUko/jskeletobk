<?php

class Config {
    const contador =    home."/contador.txt";
    const config =      home."/config.php";
    const literal =     home."/util/Literal.php";
    const login =       home."/control/Login.php";
    const sesion =      home.'/servicios/Sesion.php';
    const consultas =   home.'/dao/Consultas.php';
    
    const eventos = [
        "ping" =>  [
            "control" => [Config::login, "LoginControl"],
            "params"  => []
        ],
        "loga" => [
            "control" => [Config::login, 'LoginControl'],
            "params"  => ["usr", "pss"]
        ],
        "desloga" => [
            "control" => [Config::login, 'LoginControl'],
            "params"  => []
        ]
    ];
    const host = 'localhost';
    const root = 'root';
    const clave = 'bukobuko';
    const db = 'prueba1';
}

?>