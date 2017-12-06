<?php

use util\Literal;

// use util\Literal;

class Config {
    const CONFIG =      home.'/config.php';
    const LITERAL =     home.'/util/Literal.php';
    const LOGIN =       home.'/control/Login.php';
    const PACMANCTRL =  home.'/control/PacmanPantallasCtrl.php';
    const SESION =      home.'/servicios/Sesion.php';
    const PACMANSRV =   home.'/control/PacmanPantallasSrv.php';
    const CONSULTAS =   home.'/dao/Consultas.php';
    const PACMUSRIMAG = home.'/img/pacmanUsrs/';
    const CONTADOR =    home.'/contador.txt';
    
    
    const EVENTOS = [
        'ping' =>  [
            'control' => [Config::LOGIN, 'LoginControl'],
            'params'  => []
        ],
        'loga' => [
            'control' => [Config::LOGIN, 'LoginControl'],
            'params'  => [
                Literal::PARAM_USR, 
                Literal::PARAM_PSSWD
            ]
        ],
        'desloga' => [
            'control' => [Config::LOGIN, 'LoginControl'],
            'params'  => []
        ],
        'pacMapaNuevo' => [
            'control' => [Config::PACMANCTRL, 'PacmanPantallasCtrl'],
            'params'  => [
                Literal::PARAM_NOMBRE,
                Literal::PARAM_FILAS,
                Literal::PARAM_COLUMNAS,
                Literal::PARAM_MAPA_MAPADATA,
                Literal::PARAM_IMG_DATA
            ]
        ]
    ];
    const HOST = 'localhost';
    const ROOT = 'root';
    const CLAVE = 'bukobuko';
    const DB = 'prueba1';
}

?>