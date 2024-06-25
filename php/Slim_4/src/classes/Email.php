<?php 
namespace App\classes;



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require __DIR__.'../../../vendor/autoload.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';

 
class Email 
{ 

public function mandar_email($email,$token,$subject,$body)
    {
        global $env ; 
        $mail = new PHPMailer(true);

        $username = 'admin'; 
        $senha =  
        $smtp = "smtpcorp.prodam";
        $port = 25 ;
        $sender ='smsdtic@prefeitura.sp.gov.br';
        $auth = false ;

        // $username = 'f73cef0376c9d3'; 
        // $senha =  "12228ec13a8660"; 
        // $smtp = "sandbox.smtp.mailtrap.io";
        // $port = 25 ;
        // $sender ='lukasbreaking@gmail.com' ;
        // $auth = true ;
      
    //    $username= $env['username'];
    //    $senha = $env['senha'];z
    //    $smtp = $env['smtp'];
    //    $port= $env['portemail'];
    //    $sender = $env['sender'];
    //    $auth = $env['auth'];
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $smtp ; //'sandbox.smtp.mailtrap.io'; //$smtp;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = $auth;  //prodam = false                                 //Enable SMTP authentication
            $mail->Username   =  $username; //'f73cef0376c9d3';  //;                     //SMTP username
            $mail->Password   = $senha;                               //SMTP password
            $mail->SMTPSecure = false;            //Enable implicit TLS encryption
            $mail->SMTPAutoTLS = false;
            $mail->Port  =    $port;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
        
            //Recipients
            $mail->setFrom($sender, 'APP-CADASTRO');
            // $mail->addAddress('lucasdomingues@prefeitura.sp.gov.br', 'Joe User');     //Add a recipient
            $mail->addAddress($email, 'Admin Lucas');     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->Body    = "para seguir com a alteracao click no link : <a href='http://localhost:9000/registrar_novasenha/token=$token_url'>alterar Senha</a> ";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->CharSet ='UTF-8';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

   

}
