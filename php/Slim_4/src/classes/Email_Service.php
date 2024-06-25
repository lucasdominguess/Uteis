<?php 
namespace App\classes;

require __DIR__.'../../../vendor/autoload.php';
// require __DIR__."/Email.php";
// // require "/Infrastructure/Persistence/User/RedisConn.php";
// require __DIR__."/../../src/Infrastructure/Persistence/User/RedisConn.php";
// require __DIR__."/CreateLogger.php";
// require "/../../vendor";
// require "./vendor";
// require __DIR__.'/SendEmail.php';
// use App\classes\SendEmail;
// use App\classes\SendEmail;
// use Redis; 
// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
// use Monolog\Handler\TelegramBotHandler;
use App\classes\Email;
use App\classes\CreateLogger;
use App\Infrastructure\Persistence\User\RedisConn;



class Email_Service
{

    public function Adcionar_fila($key,$value){ 
        $redis = new RedisConn();
        $redis->rPush($key ,$value);
        
    }
    public function verificarFila(){
           
            // $redis = new Redis();
            // $redis->connect('127.0.0.1',6379);
            $redis = new RedisConn();
            $r =$redis->lRange('enviar_email', 0 ,-1);



            if (empty($r)) {
                
                print_r("Nenhum email na fila");
                exit();
                }
                
                $res = $redis->lPop("enviar_email");
                $dados = json_decode($res, true);
                $email = $dados['email'];
                $token = $dados['token'];
                $subject = $dados['subject'];
                $body = $dados['body'];
                                
                $send = new Email();
                $send->mandar_email($email,$token,$subject,$body);
                
                $log = new CreateLogger();
                $log->logger("Email_Service","Foi Enviado um Email de recuperação de senha para $email");



    
    
        }
    
}

$s = new Email_Service();
$s->verificarFila();


