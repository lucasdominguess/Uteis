<?php
declare(strict_types=1);

namespace App\Domain\User;


use JsonSerializable;
use App\classes\Enums\Role;
use App\classes\Enums\ActiveEmail;
use App\classes\Enums\ActivateUser;
use \Exception;

//id, name,email,login,ROLE,permissão
class User implements JsonSerializable
{
    const LOGIN = 'user_id';
    const NAME = 'user_name';
    const EMAIL = 'email';
    const ROLE = 'role';
    const DATE = 'datasessao';

    private static function chk_login(string $login):string{
        if($login == ''){
            throw new Exception("Login de usuario invalido", 1);
        }
        return $login;
    }
    private static function chk_nome(string $nome):string
    {
        if($nome==''){
            throw new Exception("Nome do usuario invalido", 1);
        }
        return $nome;
    }
    private static function chk_email(string $email):string
    {
        if($email==''){
            throw new Exception("Email do usuario invalido", 1);
        }
        return $email;
    }
    private static function chk_role(Role $role):Role
    {
        if($role==''){
            throw new Exception("Role do usuario invalida", 1);
        }
        return $role;
    }
    private static function chk_act_member(ActivateUser $activated):ActivateUser
    {
        if($activated==''){
            throw new Exception("Não foi possivel checar se o usuario esta ativo", 1);
        }
        return $activated;
    }
    private static function chk_act_sendmail(ActiveEmail $act_sendmail):ActiveEmail
    {
        if($act_sendmail==''){
            throw new Exception("Não foi possivel checar se o usuario quer receber um email", 1);
        }
        return $act_sendmail;
    }    

    public static function create($login, $nome,$email,$role,$activated,$sendmail)
    {
        return new User(
            self::chk_login($login),
            self::chk_nome($nome),
            self::chk_email($email),
            self::chk_role($role),
            self::chk_act_member($activated),
            self::chk_act_sendmail($sendmail)
        );
    }


    public function __construct(
        public readonly ?string $login, 
        public readonly ?string $name, 
        public readonly ?string $email, 
        public readonly ?Role $role,
        public readonly ?ActivateUser $activated,
        public readonly ?ActiveEmail $sendmail,
    ){}


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'login' => $this->login,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'active' => $this->activated,
            'send_mail' => $this->sendmail
        ];
    }
}
