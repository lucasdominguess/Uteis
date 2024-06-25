<?php 
namespace App\Application\Actions\Cadastro;

use App\classes\Traits\Message;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;

class CadastrarUserAction extends BirthdayAction 

{

    public function action(): ResponseInterface 
    {   
        ///variaveis post 
        $dados =[];
        $r = $this->birthdayRepository->insert('usuarios',$dados);
 
        return $this->respondWithData($msg);
    }
}