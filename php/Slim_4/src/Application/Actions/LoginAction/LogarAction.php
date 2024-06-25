<?php
namespace App\Application\Actions\LoginAction;

use App\classes\Enums\ActiveUser;
use App\classes\Helpers;
use App\Infrastructure\Persistence\Login\LoginRepository;
use voku\helper\AntiXSS;
use App\Domain\User\User;
// use App\classes\Enums\Role;
use App\Domain\User\UserInfo;
use App\Application\Birthday\BirthdayAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\classes\Enums\Role;


class LogarAction extends BirthdayAction
{

    public function action(): Response
    {
        $login = $this->antiXSS->xss_clean($_POST['login_rede']) ?? null;
        $pass = $this->antiXSS->xss_clean($_POST['senha_rede']) ?? null;
        $r = new LoginRepository($this->birthdayRepository);
        // $r->logar($login,$pass);
        return $this->respondWithData($r->logar($login,$pass),200);
    }

}