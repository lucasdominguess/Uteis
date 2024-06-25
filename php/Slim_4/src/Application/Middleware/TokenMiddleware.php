<?php
namespace App\Application\Middleware;
 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Slim\Psr7\Response;
use App\Domain\User\User;
use Firebase\JWT\ExpiredException;

use App\Infrastructure\Persistence\User\RedisConn;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
 
 
class TokenMiddleware {
    public function __invoke(Request $request, RequestHandler $handler)
    {  
        $response = new Response();
        global $env;
        $key = $env['secretkey'];
        $time =$env['exp_token'];
        $email = $_SESSION[User::USER_EMAIL] ?? null ;
        $cookie = $_COOKIE['token'] ?? null ;
        
        // verificando se o token existe
        if(!isset($cookie) || !isset($email)){
            session_unset();
            session_destroy();
            return $response->withHeader('Location', '/invalidtoken')->withStatus(302); 
        }
    

        // decodificando o token e verificando validade e expiraçao
        try {
            $decoded = JWT::decode($cookie, new Key($key, 'HS256'));
            
            
        } catch (ExpiredException $e) {
            // $redis = new RedisConn(); 
            // $redis->del($email);
            setcookie('token','',-1,'/');
            session_destroy();
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // verificando se o token decodificado contem a chave email correspondente 
        
        $decoded_array = (array) $decoded;
        $r = $decoded_array['email'] ; 
              
        if(!$r == $email){
            return $response->withHeader('Location', '/')->withStatus(302);
        }
        // setcookie('token','',-1,'/');
        
        $response = $handler->handle($request);
        return $response;
             


         }
        
       
        }

            

    



