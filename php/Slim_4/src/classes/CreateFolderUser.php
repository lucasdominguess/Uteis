<?php
namespace App\classes;


class CreateFolderUser 
{
/**
 * Cria uma pasta no sistema para arquivos unicos para cada usuario 
 * @param mixed $userfolder Nome da pasta 
 */
public function createFolder($userfolder)
{
    $directory = __DIR__ ."/../Application/files/arquivos/$userfolder";
    $permissions = 0755; 


    if (!file_exists($directory)) {
        try {
   
        mkdir($directory, $permissions, true);
            
            return $directory ;
        }catch (\Throwable $th) {
            return $th->getMessage() ;
        }

    }

    return $directory ;
  }
}