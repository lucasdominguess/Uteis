<?php
namespace App\Infrastructure\Persistence\Login;


use App\Domain\User\User;
use App\classes\Enums\Role;
use App\classes\Traits\Message;
use App\Application\token\Token;
use App\classes\Enums\ActiveEmail;
use App\classes\Enums\ActivateUser;
use App\Infrastructure\Persistence\Birthday\BirthdayRepository;



class LoginRepository
{
    use Message;
    public function __construct(protected BirthdayRepository $birthdayRepository)
    {
    }

    private function logar_ldap($user, $pass): array //modificar para public para fim de testes
    {
        global $env;

        $conn = @ldap_connect($env['LDAP_HOST']);
        if (!$conn) {
            throw new \Exception("Falha na comunicação com o servidor! Tente novamente.");
        }


        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldap = @ldap_bind($conn, $env['LDAP_DOMAIN'] . "\\" . $user, $pass);
        if (!$ldap) {
            throw new \Exception("Usuário ou senha inválidos! Verifique suas credenciais.");
        }

        $search = ldap_search($conn, $env['LDAP_BASE'], "sAMAccountName=$user");
        $info = ldap_get_entries($conn, $search);

        if (!isset($info[0]['mail'][0])) {
            throw new \Exception("Usuário ou senha inválidos! Verifique suas credenciais.");
        }


        $ldap_mail = $info[0]['mail'][0]; //email
        $ldap_name = $info[0]['cn'][0]; //nome do usuário
        $ldap_login = $info[0]['samaccountname'][0]; //login de rede

        return [$ldap_mail, $ldap_name, $ldap_login];

    }
    private function logar_com_x($login, $pass): ?User
    {

        [$ldap_mail, $ldap_name, $ldap_login] = $this->logar_ldap($login, $pass);

        $usuario = $this->birthdayRepository->selectUserOfId($ldap_login,'usuarios','login_rede');
        $user = new User(
            $ldap_login,
            $ldap_name,
            $ldap_mail,
            Role::USUARIO,
            ActivateUser::Inativo,
            ActiveEmail::Desativado
        );
        if (empty($usuario)) {
            $this->birthdayRepository->insert('usuarios', [
                'login_rede'=> $ldap_login, 
                'name' => $ldap_name,
                'email'=> $ldap_mail,
                'role'=> Role::USUARIO->value,
                'activate_user'=> ActivateUser::Inativo->value,
                'activate_email'=> ActiveEmail::Desativado->value,
            ]);
        }
//SELECT * FROM usuarios LIMIT 100
        return $user;
        // return $usuario = $this->birthdayRepository->selectUserOfId($ldap_login,'usuarios',$ldap_login);

    }

    private function criar_sessao(User $user)
    {
        global $env;
        $time = $env['exp_token'];
        $token = new Token($user,$time);

        // $data = [
        //     'id'=>$user->id_user,
        //     'nome'=>$user->nome,
        //     'role'=>$user->user_role,
        // ];

        // $jwt = $token->gerar($data);

        // return 1;
        return $token;


    }

    public function logar(string $login, string $pass): array
    {
        global $env;
        $login = mb_strtoupper($login);
        $er = '/^(X|D)\d{6}$/';

        if (preg_match($er, $login) && is_numeric($env['usar_ldap']) && (int) $env['usar_ldap'] === 1) {

            try {
                $user = $this->logar_com_x($login, $pass);
                $sessao = $this->criar_sessao($user);

                if (!$sessao) {
                    // $msg = new Message('fail', 'Não foi possível iniciar a sessão do usuário. Verifique se os cookies estão permitidos.');
                    return (array) $this->Message('fail', 'Não foi possível iniciar a sessão do usuário. Verifique se os cookies estão permitidos.');
                }

                
                // $msg = new Message('ok', 'Login realizado com sucesso');
                return (array) $this->Message('ok','Login realizado com sucesso');


            } catch (\Throwable $th) {
                // $msg = new Message('fail', $th->getMessage());
                return (array) $this->Message('fail',$th->getMessage());
            }
        }
    }
}