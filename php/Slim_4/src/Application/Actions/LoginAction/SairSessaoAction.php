<?php 
namespace App\Application\Actions\LoginAction;

use App\Domain\User\User;
use App\Application\Actions\User\UserAction;
use Psr\Http\Message\ResponseInterface as Response;

class SairSessaoAction extends UserAction 
{ 
    protected function action(): Response 
    {   
        
        // $this->createLogger->logger("LOGOUT",'Usuario: '.$_SESSION[User::USER_NAME].' Desconectou','info'); 
        // $this->redisConn->del($_SESSION[User::USER_EMAIL]);
        
        setcookie('token','',-1,'/');
        session_unset();
        session_destroy();

        $response= ['status'=>'ok','msg'=>'Sessao encerrada com sucesso','location'=>'/'];
        return $this->respondWithData($response);
    }
    



}




