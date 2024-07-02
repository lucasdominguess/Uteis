<?php 
namespace App\classes;

use DateTime;
use App\classes\DateVerify;
use App\classes\Enums\ActivateUser;
use App\classes\Enums\ActiveEmail;

Class Pessoa 
{
    public function __construct(
        public string|null $name ,
        public string|null  $email ,
        public string|null  $date,
        public string|null  $id_login,
        public string|null $act_member,
        public string|null  $act_email
        ) 
    {
 
    }
    public function VerifyParams()
    {   
       
        $dados=
        [
            'name'=>$this->name,
            'email'=>$this->email,
            'date'=>$this->date,
            'id_login'=>strtoupper($this->id_login),
            'activated_member'=>$this->act_member,
            'activated_email'=>$this->act_email
       ];
    
        foreach ($dados as $key => $value) {
            if ($value === null || $value === '') {
             throw new \Exception("Por favor, preencha todos os campos corretamente.");
            }
        }
    



        if (!preg_match(Regex::NAME,$this->name)) {
            throw new \Exception("Formato de nome Invalido");
            }

        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Formato de email Invalido");
            
        }
        // if (!preg_match(Regex::EMAIL_ROOT,$this->email)) {
        //     throw new \Exception("Formato de Email Invalido");
        //         }
        if (!preg_match(Regex::ID_LOGIN,$this->id_login)) {
            throw new \Exception("Formato de Login de rede Invalido");
                    }

        $atv_member = ActivateUser::tryfrom($this->act_member);
            if ($atv_member == null) {
                throw new \Exception("Digite Sim para usuario ativo ou não para inativo");
            }
     
        $atv_email = ActiveEmail::tryFrom($this->act_email);
            if ($atv_email == null) {
                throw new \Exception("Digite Sim para email ativo ou não para inativo");
            }
        return $dados ;
        // [
        //     'name'=>$this->name,
        //     'email'=>$this->email,
        //     'date'=>$this->date,
        //     'id_login'=>$this->id_login,
        //     'activated_member'=>$atv_member->value,
        //     'activated_email'=>$atv_email->value
        // ];
    }}
