<?php 
namespace App\Application\Actions\Listagem;

use DateTime;
use DateTimeZone;
use App\classes\Helpers;
use Psr\Http\Message\ResponseInterface;
use App\Application\Birthday\BirthdayAction;


class ListarAniversariosAction extends BirthdayAction 
{
    public function action(): ResponseInterface 
    {   
        
        $date =  new DateTime('now',new DateTimeZone('America/Sao_Paulo'));
        // $date->modify("+1 months");
        $d = $date->format("m");
        $r = $this->birthdayRepository->query($d);
        
    //   Helpers::dd($r);

        if(empty($r)){
            // $this->createLogger->logger('list_teste','nenhum usuario encontrado');
            $msg = ['status'=>'fail','msg'=>'nenhum aniversariante para este mes'];
            return $this->respondWithData($msg) ; 
            
        }

        $msg = ['status'=>'ok','msg'=>'menssagem'];
        return $this->respondWithData($r) ; 
    }
}