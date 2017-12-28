<?php

class CreaGuardaImagen {
    
    private $nombre;
    private $ancho;
    private $alto;
    
    function __construct($nombre, $ancho, $alto) {
        $this->nombre = home.'/data/pacmanPantallasUsrs/'.$nombre.'.png';
        $this->ancho = $ancho;
        $this->alto = $alto;
    }
    
    public function deBase64($cadena){
        $muletilla = 'data:image/png;base64,';
        if (strpos($cadena, $muletilla) == 0){
            $cadenaDecoded = base64_decode(substr($cadena, strlen($muletilla)));
            $imgEnMemoria = imagecreatefromstring($cadenaDecoded);
            if ($imgEnMemoria !== false){
                header('Content-Type: image/png');
                imagepng($imgEnMemoria);
                $nuevaImg = imagecreatetruecolor($this->ancho, $this->alto);
                imagecopy($nuevaImg, $imgEnMemoria, 0,0,0,0, $this->ancho, $this->alto);
                imagepng($nuevaImg, $this->nombre);            //El directorio esta en $nombreComp
                imagedestroy($nuevaImg);
                imagedestroy($imgEnMemoria);
                return true;
            }
        }
        return false;
    }
}

?>

