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

        // $msg= ['Ok'];

        // $date =  new DateTime('now',new DateTimeZone('America/Sao_Paulo'));
      
        //  $d = $date->format("m");
       
     ///variaveis post 
       
        $dados =[];
        $r = $this->birthdayRepository->insert('cadastros',$dados);

        $msg = ['status'=>'ok','msg'=>'Cadastro realizado com sucesso'];
        return $this->respondWithData($msg);    
            
    }
}