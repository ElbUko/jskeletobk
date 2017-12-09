<?php

use util\Literal;

// use util\Literal;

class Config {
    const CONFIG =      home.'/config.php';
    const LITERAL =     home.'/util/Literal.php';
    const LOGIN =       home.'/control/Login.php';
    const PACMANCTRL =  home.'/control/PacmanPantallasCtrl.php';
    const CREAIMG =     home.'/data/pacmanPantallasUsrs/CreaGuardaImagen.php';
    const CONTADOR =    home.'/data/contador.txt';
    const SESION =      home.'/servicios/Sesion.php';
    const PACMANSRV =   home.'/servicios/PacmanPantallasSrv.php';
    const CONSULTAS =   home.'/dao/Consultas.php';
    const PACMUSRIMAG = home.'/img/pacmanUsrs/';
    
    
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
        'pacAltaMapa' => [
            'control' => [Config::PACMANCTRL, 'PacmanPantallasCtrl'],
            'params'  => [
                Literal::PARAM_NOMBRE,
                Literal::PARAM_FILAS,
                Literal::PARAM_COLUMNAS,
                Literal::PARAM_MAPADATA,
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