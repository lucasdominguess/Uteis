<?php
 
namespace App\classes;
 
use DateTime;
use DateTimeZone;
use App\classes\CreateLogger;
use App\Infrastructure\Persistence\User\RedisConn;
 
 

class DateVerify extends DateTime
{
    public function __construct(string|null $date)
    {
        $this->setData($date);
    }
    /**
     * setData - Verifica se o formato de uma data esta valido no formato YYYY-mm-dd
     *
     * @param  ?string $date
     * @return string
     */
    private function setData(string|null $date): string
    {
        list($year, $month, $day) = explode('-', $date);
        if ($date == null) {
            throw new \Exception("Preencha o campo data");
        }
        if (!preg_match(Regex::DATE, $date)) {
            throw new \Exception("Formato de data invalida");
        }
       
        if (checkdate($month,$day,$year) === false) {
            throw new \Exception("Data invalida, favor verificar");
        }
 
        $newdate = new DateTime($date);
        $datenow = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
 
        if ($datenow<=$newdate) {
            throw new \Exception("Data invalida");
        }
 
        $intervalo = $datenow->diff($newdate);
        $resultado = $intervalo->format("%a");
 
        $resultado = $resultado / 365.25;
        $res = intval($resultado);
        if ($res < 18 || $res > 100) {
            throw new \Exception("Idade invalida Para cadastro");
 
        }
        return $date;
    }
/**
 * @method verifyDay  metodo ira verificar se a data do usuario é igual a data de hoje (desconsiderando o ano) se sim , 
 * ira adcionar o novo usuario a lista de emails service Aniversario . 
 * @param  string $name Nome do usuario
 * @param  string $email Email do usuario 
 * @param  redisConn $redis conexao do redis (responsavel para adcionar dados a fila de email service )
 * @param CreateLogger $logger ira registrar log de acordo com o resultado da operação 
 */
public function verifyDay(string $date,string $name,string $email,RedisConn $redis, CreateLogger $Logger) 
    {
        $newdate = new DateTime($date);
        $datenow = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        if ($newdate->format("m-d") == $datenow->format("m-d")  ) {
             
            $dados = json_encode([
                'email' => $email,
                'name' => $name,
                'subject' => "Feliz aniversario $name",
                'body'=>" Olá, $name!

                    Hoje é um dia muito especial, e não poderíamos deixar de celebrar junto com você. Em nome de toda a equipe da DTIC-SMS , queremos desejar a você um aniversário repleto de alegria, saúde e sucesso.
                    Você é uma parte valiosa da nossa equipe, e agradecemos por toda a dedicação e esforço que você coloca em seu trabalho diariamente. Esperamos que este novo ano de vida traga muitas realizações pessoais e profissionais.
                    Aproveite seu dia ao máximo!

                    Com os melhores cumprimentos,


                    DTIC-SMS "
                ]);
                $redis->rPush('enviar_email_service',$dados);
                $Logger->loggerCSV("LOG-Email-Aniversario","$email Adcionado a fila Email-service");

        }
    }


}


