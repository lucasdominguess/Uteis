<?php
namespace App\Application\Actions\Cadastro;

use App\Application\Birthday\BirthdayAction;
use Psr\Http\Message\ResponseInterface;
use DateTime;
use DateTimeZone;

class CadastrarNiverAction extends BirthdayAction
{ 
    public function action(): ResponseInterface 
    {   
        $name =$this->antiXSS->xss_clean($_POST['name']) ?? null;
        $email =$this->antiXSS->xss_clean($_POST['email']) ?? null;
        $date =$this->antiXSS->xss_clean($_POST['date']) ?? null;
        $id_login =$this->antiXSS->xss_clean($_POST['id_login']) ?? null;
        $act_member =$this->antiXSS->xss_clean($_POST['activated_member']) ?? null;
        $act_email =$this->antiXSS->xss_clean($_POST['activated_email']) ?? null;
       
     $dados=
        [
       'name'=>$name,
       'email'=>$email,
       'date'=>$date,
       'id_login'=>$id_login,
       'activated_member'=>$act_member,
       'activated_email'=>$act_email
       ];
       
       foreach ($dados as $key => $value) {
        if($dados[$key]== null| $dados[$key]==''){
          $msg = ['status' => 'fail', 'msg' => "Por favor preencha todos os campos"];
          return $this->respondWithData($msg);
        }
        
      }

        $r = $this->birthdayRepository->insert('cadastros',$dados);

        $msg = ['status'=>'ok','msg'=>'Cadastro realizado com sucesso'];
        return $this->respondWithData($msg);    
            
    }
}