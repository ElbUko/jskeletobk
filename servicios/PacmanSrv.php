<?php
namespace servicios;

use util\Literal;
use dao\Consultas;

class PacmanSrv {
    
    private function cargaUsuarioLogado(){
        $sesion = new Sesion();
        $this->usuario = $sesion->usuario_logado();
    }
    private function trataImagenSubida(){
        //TODO - seguridad a imagen
        return base64_decode(substr($this->imgData,22));
    }
    public function pacMapaNuevo($in){
        $this->cargaParametros($in);
        $this->cargaUsuarioLogado();
        
        $nombreCompleto = \Config::PACMUSRIMAG . $this->nombre . '.png';
        $img = $this->trataImagenSubida();
        $im = imagecreatefromstring($img);
        if ($im !== false) {
            header('Content-Type: image/png');
            imagepng($im);
            //imagedestroy($im);
        }
        else {
            echo 'An error occurred.';
        }
        //Creo el fichero para almacenar la imagen creada en memoria
        $ancho = 10*$nCol;
        $alto = 10*$nFil;
        $nuevaImg = imagecreatetruecolor($ancho, $alto);
        imagecopy($nuevaImg, $im, 0,0,0,0, $ancho, $alto);
        imagepng($nuevaImg,$nombreCompleto);            //El directorio esta en $nombreComp
        imagedestroy($nuevaImg);
        imagedestroy($im);

        $consultas = new Consultas();
        $consultas->metePantalla($pacTalla);
    }
    
    $nombreComp = dirname(__DIR__)."/../img/mapasUsuarios/$nombre.png";
    //GUARDO UN FICHERO .PNG CON LA IMAGEN DE LA PANTALLA
    //Creo una imagen en memoria a partir de la cadena en base64:pacman/autogenerados
    $im = imagecreatefromstring($img);
    
    //LLAMO A CONSULTAS PARA HACER LA INSERCION EN BBDD
    include_once(dirname(__DIR__)."/dao/consultas.php");
    $chulta = metePantalla($pantalla, $nombre, $usuario, $nFil, $nCol);
    return $chulta;
}

?>