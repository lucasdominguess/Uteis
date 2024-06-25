<?php
namespace App\Application\Actions\User\controlers\arquivos;


use ZipArchive;

use App\Domain\User\User;

use App\classes\CreateFolderUser;
use App\Application\Actions\Action;
use App\Infrastructure\Helpers;
use Psr\Http\Message\ResponseInterface;


class UploadAction extends Action
{




  protected function action(): ResponseInterface
  {
    $file = $_FILES['file'];
    // Helpers::dd($file)
;    // $info = pathinfo($file['name'][0]);

    $userfolder = 'ID_0' . $_SESSION[User::USER_ID] . "_" . strtoupper($_SESSION[User::USER_NAME]);

    $folder = new CreateFolderUser();
    $path = $folder->createFolder($userfolder);

    $names = $file['name'];
    $tmp_name = $file['tmp_name'];
    $fileSize = $file['size'];

    if ($_FILES['file']['error'][0] == 4) {
      $msg = ['status' => 'fail', 'msg' => 'Nenhum Arquivo foi enviado!'];
      return $this->respondWithData($msg);
    }

    foreach ($names as $index => $value) {

      $ext = pathinfo($names[$index], PATHINFO_EXTENSION);

      if (!in_array($ext, ['png', 'jpg', 'gif', 'csv', 'txt'])) {
        $msg = ['status' => 'fail', 'msg' => "Formato invalido! $value"];
        return $this->respondWithData($msg);
      }
      if ($fileSize[$index] >= 160000) { 
        $msg = ['status' => 'fail', 'msg' => "Tamanho de arquivo excedido! $value"];
        return $this->respondWithData($msg);
      }
      // $arqName = uniqid().'.'.$ext;  // casi queria criar nome unico para os arquivos 
      // $name = strtoupper(str_replace([" ","%"],'_',$names[$index]));
      
      //movendo arquivo para pasta do usuario 
      move_uploaded_file($tmp_name[$index], "$path/$names[$index]");

      $file['id_adm'][$index] = $_SESSION[User::USER_ID];
      $file['create_time'][$index] = $GLOBALS['datefullForm'];
      $file['folder'][$index] = $userfolder;
      $file['path'][$index] = $path . "/";



    }
    // try {
    //   //salvando dados do arquivo no banco 
    //   $insert = new CreateRepository($this->sql);
    //   $insert->createArquivos($file);
    // } catch (\PDOException $e) {
    //   if ($this->sql->errorCode() == '23000') {
    //     $resposta = ['status' => 'fail', 'msg' => "O mesmo nome nao pode ser inserido"];
    //     return $this->respondWithData($resposta);

    //   }
    // }

    $msg = ['status' => 'ok', 'msg' => 'Arquivo enviado com sucesso!'];
    return $this->respondWithData($msg);


    // Fazer upload em pastas de acordo com a extensao do arquivo 
    // if(in_array($ext, ['png','jpg','gif'])){
    //   // $pastaArquivos = __DIR__ ."./../../../files/arquivos";  
    //   // $pastaImg = __DIR__ ."./../../../files/arquivos/imagens"; 
    //     // chmod(__DIR__ ."./../../../files/arquivos",0755);
    //     // mkdir($pastaArquivos,0755);

    //   $file->upload(__DIR__ ."./../../../files/arquivos/imagens");

    // }
    // if(in_array($ext, ['pdf','xls'])){
    //   $file->upload(__DIR__ ."./../../../files/arquivos/planilhas");
    // }
    // if(in_array($ext, ['csv','txt',''])){
    //   $file->upload(__DIR__ ."./../../../files/arquivos");
    // }    







  }





}
