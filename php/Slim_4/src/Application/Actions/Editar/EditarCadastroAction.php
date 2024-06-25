<?php 
namespace App\Application\Actions\Editar;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;


class EditarCadastroAction extends BirthdayAction 
{
    public function action(): ResponseInterface 
    { 
      
      $id = $_POST['id'] ?? null ;
      $name =$this->antiXSS->xss_clean($_POST['name']) ?? null;
      $email =$this->antiXSS->xss_clean($_POST['email']) ?? null;
      $date =$this->antiXSS->xss_clean($_POST['date']) ?? null;
      $id_login =$this->antiXSS->xss_clean($_POST['id_login']) ?? null;
      $act_member =$this->antiXSS->xss_clean($_POST['activated_member']) ?? null;
      $act_email =$this->antiXSS->xss_clean($_POST['activated_email']) ?? null;


        if (!isset($id)) {
            $msg = ['status'=>'fail','msg'=>'Necessario fornecer um Id'];
          return $this->respondWithData($msg,404);

        }
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
        
      $r= $this->birthdayRepository->update($id,'cadastros',$dados);

        if ($r== 0) {
          $msg = ['status'=>'fail','msg'=>'Falha ao atualizar dados'];
          return $this->respondWithData($msg);
        }

          $msg = ['status'=>'ok','msg'=>'Dados atualizados com sucesso'];
          return $this->respondWithData($msg);
      }
        
    
}