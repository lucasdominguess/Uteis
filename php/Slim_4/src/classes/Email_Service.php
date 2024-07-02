<?php 
namespace App\classes;

require __DIR__.'../../../vendor/autoload.php';

use App\classes\Email;
use App\classes\CreateLogger;
use App\Infrastructure\Persistence\User\RedisConn;



class Email_Service
/**
 * Classe responsavel por verificar um serviço de envio de emails 
 * 
 * @author lucas_domingues 
 */
{
    /**
     * @method  Adcionar_fila() Metodo responsavel para adcionar email a uma fila no redis 
     * @param $key titulo da fila neste exemplo setada como enviar_email_service 
     * @param string|array $value valor em string ou array 
     * 
     */
    public function Adcionar_fila($key,$value){ 
        $log = new CreateLogger();
        $redis = new RedisConn();
        $redis->rPush($key ,$value);
        $log->loggerCSV("LOG-Adcionar-fila","$value foi adcionado a fila $key");
       


        
    }
    /**
     *@method verificarFila() Metodo responsavel para verificar fila em redis e invocar classe pra envio do email 
     *
     */
    public function verificarFila(){
           
            // $redis = new Redis();
            // $redis->connect('127.0.0.1',6379);
        while(true)
         {
           sleep(2);
             try {
                 $log = new CreateLogger();
                 $redis = new RedisConn();
                 $r =$redis->lRange('enviar_email_service', 0 ,-1);
     
                 if (empty($r)) {
                     $log->loggerCSV("LOG_Email_Service","Nenhum Email na fila de enviar_email_service");
                     exit();
                     }
                     
                     
                     $res = $redis->lPop("enviar_email_service");
     
                     $dados = json_decode($res, true);
                     $email = $dados['email'];
                     $name = $dados['name'];
                     $subject = $dados['subject'];
                     $body = $dados['body'];
                                     
                     $send = new Email();
                     $send->mandar_email($email,$name,$subject,$body);
                     
                   
                     $log->loggerCSV("LOG_Email_Service","Email para $email enviado com sucesso");
          
             } catch (\Throwable $th) {
                 $msg = $th->getMessage();
                 $redis->rPush("enviar_email_service",$res);
                 $log->loggerCSV("ERROR_Email_Service","$email foi adcionado a fila novamente");
                 $log->loggerTelegran("ERROR-EMAIL-SERVICE" ,"falha em Serviço de email $msg");
                 $log->loggerTelegran("ERROR-EMAIL-SERVICE" ," email $email foi adcionado a fila novamente");
                 throw new \Exception('Erro ao enviar email');
             }
 
         }
        }
    
}

$s = new Email_Service();
$s->verificarFila();


