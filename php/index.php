<?php
    //incluyo los archivos necesarios
    include("php/control/session.php");

    //Activacion de la sesion
    session_start();    
    if (isset($_SESSION['usuario'])){
        echo("<script>var defaultUsr='".$_SESSION['usuario']."', invitado = false;</script>\n");
    }
    else {
        $usuarioInvitado = creaInvitado();  //Contador para la sesion de invitado
        echo("<script>var defaultUsr= '$usuarioInvitado', invitado = true;</script>\n");
        $_SESSION['usuario'] = $usuarioInvitado;
    }
?>