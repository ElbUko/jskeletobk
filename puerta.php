<?php
include_once(dirname(__DIR__).'/jskeletobk/config.php');   

function cors(){
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    return;
}

function trataCuerpo(){
    //Tomo el cuerpo de la entrada al servicio
    $request_body = file_get_contents('php://input');
    if ($request_body == null){
        header("HTTP/1.1 400 Bad Request");
        throw new Exception('peticion sin body');
    }

    //Parseo la informacion de entrada
    try {
        $json = json_decode($request_body, true);
    } catch (Exception $e) {
        header("HTTP/1.1 400 Bad Request");
        throw new Exception('cuerpo no parseable');
    }

    return $json;
}

function manejaEvento($manejador, $event, $in){
    if (isset($event)){
        if (isset(($manejador))){
            include_once($manejador['control'][0]);
            $control = new $manejador['control'][1];

            if (count($manejador['params'])>0){
                foreach($manejador['params'] as $param){
                    $$param = $in[$param];
                    $params[$param] = $$param;
                }
            }

            $out = (isset($params))?
                $control -> $event($params):
                $control -> $event();

            return $out;
        }
    }
    return -1;
}

cors();
$in = trataCuerpo();
$event = $in['evt'];
$manejador = $eventos[$event];
$out = manejaEvento($manejador, $event, $in);

if ($out == -1){
    header("HTTP/1.1 400 Bad Request");
}
else {
    header("Content-Type", "application/json");
    echo json_encode($out);
}

return;
