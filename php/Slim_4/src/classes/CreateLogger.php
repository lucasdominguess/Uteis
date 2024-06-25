<?php
namespace App\classes;



use Monolog\Level;
use Monolog\Logger;
use App\Domain\User\User;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SendGridHandler;
use Monolog\Handler\TelegramBotHandler;

use Monolog\Handler\NativeMailerHandler;
use PhpParser\Lexer\TokenEmulator\ReadonlyTokenEmulator;

class CreateLogger {
    
   
    public function logger ($dirname ,$msg, $modo = 'info', array|string $extra = null){
        $now = new \DateTimeZone( 'America/Sao_Paulo');
        $now_form =(new \DateTime('now',$now))->format('d-m-Y');
        
        $date = $GLOBALS['days'] ?? $now_form ;
        $logger = new Logger($dirname);

        // $logger->pushProcessor(function ($record) use ($extra) { 
        //     $record["extra"]["server"] = $extra ;
        //     return $record ;
        // });
 
        $logger->pushHandler(new StreamHandler(dirname(__FILE__)."/../../logs/LOG_".$date.".csv"));
        $logger->$modo($msg);
}
    public function logTelegran($msg, $modo = 'warning', array|string $extra = null){
        $logger = new Logger('TelegranBot');
        
        $logger->pushProcessor(function ($record) use ($extra) { 
            $record["extra"]["server"] = $extra ;
            return $record ;
        });
    

        $logger->pushHandler( new TelegramBotHandler(
            apiKey:"6896066213:AAEfj5TxiJaH6m2CEsP9fJZh3BUvpPfypzw",
            channel:"@phpAplicationweb",
            level:Level::Warning
    ));
        $logger->$modo($msg);
        
       
    

} 
    public function Emaillogger(string|array $to ,string $subject , string $from) { 
        $logger = new Logger ( 'Emailloger'); 
        $logger->pushHandler(new NativeMailerHandler(
            to : $to ,
            subject : $subject , 
            from : $from ,
            level : Level::Critical

        )); 
        $logger->critical('Esta é uma mensagem de erro crítica!');
        
    }


}