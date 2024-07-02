<?php
namespace App\classes;



class UploadFoto 
{
    public function __construct($file,$id_login) {
        // $this->validFotoUser($file);
    }

    public function validFotoUser($file,$id_login)
    {   
        $directory = __DIR__ ."/../Domain/upload_fotos";

        if ($file['error'] == 4 ) {
           
            return "DEFAULT.png";
          }


        $names = $file['name'];
        $tmp_name = $file['tmp_name'];
        $fileSize = $file['size'];
        
        

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array($ext, ['png', 'jpg'])) {
            throw new \Exception("Formato de foto invalida!");
        }
        if ($fileSize > 10000000) {
            throw new \Exception("Tamanho de arquivo excedido! O tamanho máximo permitido é 10 MB.");
        }
        
        $newname = strtoupper("$id_login.$ext"); 
        $path = "$directory/$newname" ; 
        

        move_uploaded_file($tmp_name,$path);

        return $newname ; 

        // function resizeImage($sourcePath, $destinationPath, $newWidth, $newHeight) {
        //     $imagick = new \Imagick($sourcePath);
        //     $imagick->resizeImage($newWidth, $newHeight, \Imagick::FILTER_LANCZOS, 1);
        //     $imagick->setImageCompressionQuality(75);
        //     $imagick->writeImage($destinationPath);
        //     $imagick->clear();
        //     $imagick->destroy();
        // }
        
        // resizeImage('imagem_original.jpg', 'imagem_redimensionada.jpg', 800, 600);
        

}
}