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
        $cadenaDecoded = base64_decode($cadena);
        $imgEnMemoria = imagecreatefromstring($cadenaDecoded);
        if ($imgEnMemoria !== false){
            header('Content-Type: image/png');
            imagepng($imgEnMemoria);
            $nuevaImg = imagecreatetruecolor($this->ancho, $this->alto);
            imagecopy($nuevaImg, $imgEnMemoria, 0,0,0,0, $this->ancho, $this->alto);
            imagepng($nuevaImg, $this->nombre);            //El directorio esta en $nombreComp
            imagedestroy($nuevaImg);
            imagedestroy($imgEnMemoria);
        }
    }
}

?>

