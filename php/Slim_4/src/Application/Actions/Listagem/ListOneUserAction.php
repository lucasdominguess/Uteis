<?php 
namespace App\Application\Actions\Listagem;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;



class ListOneUserAction extends BirthdayAction 

{
    public function action(): ResponseInterface 
    {
        $id = $_GET['id'] ?? null ; 

          
        if(!isset($id)){
            $msg = ['status'=>'fail','msg'=>'Necessario fornecer um ID'];
            return $this->respondWithData($msg);
        }

       $r = $this->birthdayRepository->selectUserOfId($id,'cadastros');
        if (empty($r)) {
            $msg = ['status'=>'fail','msg'=>'Nao existe cadastro com esse Id'];
            return $this->respondWithData($msg);
        }

        return $this->respondWithData($r);
    }
}