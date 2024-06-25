<?php
namespace App\Application\Actions\Cadastro;
use App\Application\Actions\Action;
use App\Application\Birthday\BirthdayAction;
use App\Infrastructure\Persistence\User\UpdateRepository;
use Psr\Http\Message\ResponseInterface;
use App\Infrastructure\Persistence\User\Sql;
use App\Infrastructure\Persistence\User\SelectRepository;
use DateTime;
use DateTimeZone;

class CadastrarAction extends BirthdayAction
{ 
    public function action(): ResponseInterface 
    {
     
        $msg= ['Ok'];

        // $date =  new DateTime('now',new DateTimeZone('America/Sao_Paulo'));
      
        //  $d = $date->format("m");
       
       
        // $r = $this->birthdayRepository->insert('teste',"meiltest@gmail","1999-05-02","x449023","sim","sim");
        // $r = $this->birthdayRepository->insert('teste4',"meil4test@gmail","2000-05-02","x449024","nao","sim");
        // $r = $this->birthdayRepository->query($d);
        // $r = $this->birthdayRepository->selectUserOfId(2);
        // $r = $this->birthdayRepository->selectFindAll();
        // $r = $this->birthdayRepository->delete(4);
        // $r =  $this->birthdayRepository->update('1',['name'=>'jailsonzinho','email'=>'emailnovo@mail']);



        
        return $this->respondWithData($msg);        
        // return $this->respondWithData($msg);        
    }
}