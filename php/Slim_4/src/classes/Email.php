<?php 
namespace App\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require __DIR__.'../../../vendor/autoload.php'; // Necessario caso a classe seja ultilizada como um serviço 
// require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
// require '../../vendor/phpmailer/phpmailer/src/Exception.php';


class Email 
{ 
/**
 * @method mandar_email  metodo responsavel por fazer o envio de email 
 * OBS: caso essa classe esteja fora da aplicação (como serviço) buscar com require "caminho_seuprojeto/vendor/autoload.php"
 * @param string|array $email email do usuario , podendo passar um array com varios emails 
 * @param string $subject Titulo do email 
 * @param string $body Corpo do email 
 * @author Lucas_Domingues
 *  
 * */
public function mandar_email(string |array $email,$name,string $subject,string $body)
    {
        global $env ; 
        $mail = new PHPMailer(true);
        //config manual
        $username = 'admin'; 
        $senha =  
        $smtp = "smtpcorp.prodam";
        $port = 25 ;
        $sender ='smsdtic@prefeitura.sp.gov.br';
        $auth = false ;

         //config sandbox_mailtrap
        // $username = 'f73cef0376c9d3'; 
        // $senha =  "12228ec13a8660"; 
        // $smtp = "sandbox.smtp.mailtrap.io";
        // $port = 25 ;
        // $sender ='lukasbreaking@gmail.com' ;
        // $auth = true ;
          
        // config $env (Pode nao funcionar caso esta classe seja ultilizada como serviço) 
    //    $username= $env['username'];
    //    $senha = $env['senha'];z
    //    $smtp = $env['smtp'];
    //    $port= $env['portemail'];
    //    $sender = $env['sender'];
    //    $auth = $env['auth'];
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
            $mail->isSMTP();                                            
            $mail->Host       = $smtp ; 
            $mail->SMTPAuth   = $auth;  //prodam = false                              
            $mail->Username   =  $username; 
            $mail->Password   = $senha;                             
            $mail->SMTPSecure = false;          
            $mail->SMTPAutoTLS = false;
            $mail->Port  =    $port;                                  
            //Recipients
            $mail->setFrom($sender, 'WEB-APLICATION');
            //
            $mail->addAddress($email, 'Admin Lucas');    
        
            //Content
            $mail->isHTML(true);                               
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->CharSet ='UTF-8';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (\Exception $e) {
            throw new \Exception("Não foi possivel enviar email {$mail->ErrorInfo}");
        }
    }

   

}
