<?php
namespace App\classes;



use Monolog\Level;
use Monolog\Logger;
use App\classes\Email;
use Monolog\Handler\StreamHandler;


use Monolog\Handler\TelegramBotHandler;

/**
 * Classe responsavel por criar logs de sistema 

 */
class CreateLogger {
    
/**
 * @method mixed logger() Log cria um arquivo CSV nomeado com data atual em seu conteudo ira conter msg com erro especificado e seu level 
 * @param string $title Titulo do log (ira formatar para maiusculo e substituir caracteres especiais por _ )
 * @param string $msg Menssagem com erro detalhado   
 * @param string $nivel Nivel do log setado por padrao INFO 
 * @param array|string $extra Conteudo extra (opcional) enviando com pushProcessor , setado como null por padrao
 * @author Lucas_Domingues
    */
    public function loggerCSV (string $title ,string $msg, string $nivel = 'info', array|string $extra = null){
        $now = new \DateTimeZone( 'America/Sao_Paulo');
        $now_form =(new \DateTime('now',$now))->format('d-m-Y');
        
        $ftitle = strtoupper(str_replace([' ','.','-','*'],'_',$title));
        $date = $GLOBALS['days'] ?? $now_form ;
        $logger = new Logger($ftitle);

        // $logger->pushProcessor(function ($record) use ($extra) { 
        //     $record["extra"]["server"] = $extra ;
        //     return $record ;
        // });
 
        $logger->pushHandler(new StreamHandler(dirname(__FILE__)."/../../logs/LOG_".$date.".csv"));
        $logger->$nivel($msg);
}
/**
* @method mixed loggerTelegran() ferramenta do telegran ira mandar msg para o desenvolvedor com erro de nivel Warning 
* Invocando tbm metodo logger e logEmail 
* @param string $title Titulo do log (ira formatar para maiusculo e substituir caracteres especiais por _ )
* @param string $msg Menssagem com erro detalhado   
* @param bool $sendemail Torna o envio de log por email Opçional 
* @param string $nivel Nivel do log setado por padrao WARNING 
* @param array|string $extra Conteudo extra (opcional) enviando com pushProcessor , setado como null por padrao
* @author Lucas_Domingues
**/
    public function loggerTelegran(string $title ,string $msg, bool $sendEmail = false ,string $nivel = 'warning', array|string $extra = null){
        $ftitle = strtoupper(str_replace([' ','.','-'],'_',$title));
        $logger = new Logger(strtoupper($ftitle));
        
        // $logger->pushProcessor(function ($record) use ($extra) { 
        //     $record["extra"]["server"] = $extra ;
        //     return $record ;
        // });
    

        $logger->pushHandler( new TelegramBotHandler(
            apiKey:"6896066213:AAEfj5TxiJaH6m2CEsP9fJZh3BUvpPfypzw",
            channel:"@Aniversario_AppWeb",
            level:Level::Warning
    ));
        $this->loggerCSV($title,$msg,$nivel);
        if ($sendEmail) {
            $emails = ['lucasdomingues@prefeitura.sp.gov.br','tlettieri@prefeitura.sp.gov.br'];
            $this->loggerEmail($title,$msg,$emails);
        }
        $logger->$nivel($msg);
        
        
       
    

}  
/**
 * @method mixed loggerEmail() Envia um email para o desenvolvedor responsavel com erro Critico
 * @param string $title (subject) Titulo do email (ira formatar para maiusculo e substituir caracteres especiais por _ )
 * @param string $msg (body)Corpo do email com Menssagem de erro detalhado   
 * @param string $nivel Nivel do log setado por padrao critical 
 * @param array|string $extra Conteudo extra (opcional) enviando com pushProcessor , setado como null por padrao
 * @author Lucas_Domingues
 */
    public function loggerEmail(string $title ,string $msg ,string|array $to ="lucasdominguesofficial@gmail.com",array|string $extra = null) { 
        $fsubject = strtoupper(str_replace(['.','-'],'_',$title));
        $logger = new Logger ($fsubject); 

        $logger->pushProcessor(function ($record) use ($extra) { 
            $record["extra"]["server"] = $extra ;
            return $record ;
        });
        $e = new Email;
        $e->mandar_email($to,null,$fsubject,$msg);
        $logger->critical('Esta é uma mensagem de erro crítico!');
        
    }


}