<?php 
namespace App\Application\Actions\Editar;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;


class EditarCadastroAction extends BirthdayAction 
{
    public function action(): ResponseInterface 
    {
      $id = $_POST['id'] ?? null ;



        if (!isset($id)) {
            $msg = ['status'=>'fail','msg'=>'Necessario fornecer um Id'];
          return $this->respondWithData($msg,404);

        }
        $dados=[];
        
      $r= $this->birthdayRepository->update($id,'cadastros',$dados);

        if ($r== 0) {
          $msg = ['status'=>'fail','msg'=>'Falha ao atualizar dados'];
          return $this->respondWithData($msg);
        }
        
        
    }
}