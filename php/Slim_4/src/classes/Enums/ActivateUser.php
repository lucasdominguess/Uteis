<?php
namespace App\classes\Enums;

enum ActivateUser: string{
    case Ativado = 'sim';
    case Inativo = 'nao';

}

// try {
//     $chk = CheckMember::From('EmailInativos');
//     // if($chk === null){
//     //     throw new \Exception("Invalido");
//     // }
//     print $chk->name;
// } catch (\Throwable $e) {
//     echo $e->getMessage();
// }
