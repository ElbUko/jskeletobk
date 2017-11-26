<?php
namespace util;

class Config
{
    public $eventos = [
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
    
    #Datos de conexion
    public $host = 'localhost';
    public $root = 'root';
    public $clave = 'bukobuko';
    public $db = 'prueba1';
}

