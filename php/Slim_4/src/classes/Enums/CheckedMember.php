<?php
namespace App\classes\Enums;

enum CheckMember: string{
    case UsuarioAtivado = 'UsuarioAtivado';
    case UsuarioInativo = 'UsuarioInativo';
    case EmailAtivado = 'EmailAtivado';
    case EmailInativo = 'EmailInativo';

}

try {
    $chk = CheckMember::From('EmailInativos');
    // if($chk === null){
    //     throw new \Exception("Invalido");
    // }
    print $chk->name;
} catch (\Throwable $e) {
    echo $e->getMessage();
}

// var_dump(CheckMember::UsuarioAtivado->value);

// class User{
//     public function __construct(
//         public string $name,
//         public string $email,
//         public string $date,
//         public string $id_login,
//         public $activated_member,
//         public $activated_email,
//     ) 
//     {
//     }
// }

// $teste = new User('lucas','test@mail','1999-05-02','x999999',CheckMember::UsuarioInativo->name,CheckMember::EmailAtivado->name);
// var_dump($teste->activated_email);
