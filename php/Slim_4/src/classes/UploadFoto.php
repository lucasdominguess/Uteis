<?php
namespace App\classes;

use Imagick;
use App\classes\Helpers;



class UploadFoto 
{
    /**
     * Classe responsavel por verificar um envio de foto enviado pelo metodo $_FILE 
     * Renomeia o arquivo de acordo com o id do usuario , caso nenhuma foto seja enviada no ato do cadastro Usuario recebe uma foto DEFAULT.png
     * @param mixed $file arquivo enviado atraves do metodo $_file 
     * @param string|int $id_login Id do usuario que sera ultizado para renomear o arquivo 
     */
    public function __construct($file,string|int $id_login) {
        // $this->validFotoUser($file);
        
    }
    
    /**
     * @method mixed validFotoUser methodo responsavel por verificar um arquivo tipo file 
     * Verifica tambem a extensão do arquivo  
     */
    public function validFotoUser($file,$id_login=null)
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
        
            // if ($id_login == null ) {
            //     $newname = uniqid().'.'.$ext;
            // }else{
            //     $newname = strtoupper("$id_login.$ext"); 

            // }

        // Helpers::dd($file);

        
        $newname = strtoupper("$id_login.$ext"); 
        $path = "$directory/$newname" ; 
        
        // Helpers::dd($path);


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


//  public function redimencionarImagem($sourcePath, int $newWidth = 800, int $newHeight = 600 ,string $destinationPath = null)
//  {
//             $imagick = new Imagick($sourcePath);
//             $imagick->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
//             $imagick->setImageCompressionQuality(75);
//             // $imagick->writeImage($destinationPath);
//              //criar miniatura da imagem 
//             // $imagick->thumbnailImage(200,50);

//             // $imagick->clear();
//             // $imagick->destroy();

//             return $imagick ; 
// }
        
        
        

}