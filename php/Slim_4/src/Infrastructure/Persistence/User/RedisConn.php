<?php
namespace App\Infrastructure\Persistence\User;

use Redis;
use RedisException;
class RedisConn extends Redis
{      
    protected string $host;
    protected int $port;
    function __construct()
    {  
         
        try {
        $config = parse_ini_file(__DIR__.'/../../../../config.ini', true);

        if (!$config) {
            throw new RedisException('Failed to parse configuration file.');
        }
        
        $this->host = $config['redis']['redis_host'];
        $this->port =$config['redis']['redis_port'];
        $this->connect($this->host, $this->port);
       
        } catch (RedisException $e) {
            
            throw new RedisException("Falha ao conectar ao servidor Redis em {$this->host}:{$this->port}. Error: " . $e->getMessage(), 0, $e);
        }
    }

    
    
}


// $redisUser = new RedisConn();
// $redisUser->lPush('enviar_email','redisConn_@gmail');
// $redisUser->hset('user','nome','rodrigo o bruxo do front-end');

// $redisUser->hset('animal','raça','dog caramelo');
// hget estagiario nomes

//    $redisUser->hset('Usuario', 'nome',$_SESSION[User::USER_NAME] , 'email', $_SESSION[User::USER_EMAIL] , 'nivel', $_SESSION[User::USER_NIVEL]); 