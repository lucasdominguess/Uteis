<?php 
namespace App\Application\Actions\Listagem;

use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;

class ListarTodosAction extends BirthdayAction 
{ 
    public function action(): ResponseInterface 
    {   

  
       $r =$this->birthdayRepository->selectFindAll("cadastros");
       
       return $this->respondWithData($r);
    }
}