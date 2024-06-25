<?php 
namespace App\Application\Actions\Excluir;
use App\classes\Helpers;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;


class ExcluirCadastroAction extends BirthdayAction 
{
    public function action(): ResponseInterface 

    {
        $id = $_GET['id'] ?? null; 
        
        if(!isset($id)){
            $msg = ['status'=>'fail','msg'=>'Necessario fornecer um ID'];
            return $this->respondWithData($msg);
        }

        try {
          $r =  $this->birthdayRepository->update($id,'cadastros',['activated_member'=>'sim','activated_email'=>'sim'],'id');

            if ($r == 0) {
                $msg = ['status'=>'fail','msg'=>'Nao existe cadastro com esse Id'];
                return $this->respondWithData($msg);
            }

            $msg = ['status'=>'ok','msg'=>'cadastro desativado com sucesso '];
        } catch (\Throwable $th) {
            
        }
        return $this->respondWithData($msg);
    }

}
