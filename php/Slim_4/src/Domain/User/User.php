<?php

declare(strict_types=1);

namespace App\Domain\User;


use JsonSerializable;
use App\classes\Enums\Role;
use App\classes\Enums\ActiveEmail;
use App\classes\Enums\ActivateUser;


//id, name,email,login,ROLE,permissão
enum UserInfo: string{
    case USER_Login = 'ldap_login';
    case USER_Name = 'ldap_name';
    case USER_Email = 'ldap_email';
}
class User implements JsonSerializable
{

    public function __construct(
        public readonly string $login, 
        public readonly string $name, 
        public readonly string $email, 
        public readonly Role $role,
        public readonly ActivateUser $activated,
        public readonly ActiveEmail $sendmail,
    ){}


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'login' => $this->login,
            'name' => $this->name,
            'email' => $this->email,
            'permission' => $this->role,
            'active' => $this->activated,
            'send_mail' => $this->sendmail
        ];
    }
}
