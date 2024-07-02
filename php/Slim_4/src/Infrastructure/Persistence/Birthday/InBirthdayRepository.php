<?php
namespace App\Infrastructure\Persistence\Birthday;

use App\classes\Helpers;
use PhpParser\Node\Stmt;
use App\Domain\User\User;
use App\classes\Enums\Role;
use App\classes\Enums\ActiveEmail;
use App\classes\Enums\ActivateUser;
use App\Infrastructure\Persistence\User\Sql;
use function PHPUnit\Framework\throwException;
use App\Infrastructure\Persistence\Birthday\BirthdayRepository;

class InBirthdayRepository implements BirthdayRepository { 
    function __construct(private Sql $sql) 
    {

    }
    
    public function insert($table,$dados) :int
    {
        try {
            $stmt = $this->sql->insert($table,$dados);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
                if ($e->getCode() == '23505') {
                    

                    throw new \PDOException("Falha ao inserir dados! O campo de email ou o ID de login pode já estar em uso.");
                  }
            throw new \PDOException("Falha ao cadastrar usuario");
            // return 0;
        }
   }

    public function delete($id,$table,string|int $params = 'id'):int
    {
        $stmt= $this->sql->delete($id,$table);
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function selectFindAll($table) :array| null
    {
        $stmt = $this->sql->selectFindAll($table);
        $stmt->execute();
        $r=$stmt->fetchAll(\PDO::FETCH_ASSOC); 
        
        return $r;
    }

    public function selectUserOfId($id,$table,$params='id') :array |null
    {
        $stmt = $this->sql->selectUserOfId($id,$table,$params);
        $stmt->execute();
        $r=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $r;
    }

    public function update($id,$table,$dados,$params='id') : int 
    {   
        $stmt  = $this->sql->update($id,$table,$dados,$params);
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            if ($e->getCode() == '23505') {
                throw new \PDOException("Falha ao atualizar dados! O campo de email ou o ID de login pode já estar em uso.");
              }
        throw new \PDOException("Falha ao atualizar dados do usuario");
            }
    }

    public function query($date) :array |null 
    {
        $stmt=$this->sql->prepare(
        "SELECT * from cadastros , to_char(date,'mm') as mes where  mes = :date and activated_email = 'sim' and activated_member = 'sim' order by date");
        $stmt->bindValue(':date',$date);
        try {
            $stmt->execute();
            $r=$stmt->fetchAll(\PDO::FETCH_ASSOC); 
            return $r ;
        } catch (\Throwable $e) {
            throw new \Exception('Erro no banco de dados');
        }
    }
    public function selectUserByLogin($login):?User
    {
            $stmt = $this->sql->prepare("select * from usuarios where login_rede = :login");
            $stmt->bindValue(":login",$login);
            $stmt->execute();
            $r=$stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (empty($r)) {
                return $users = null;
            }
            $users= new User($r[0]['login_rede'],$r[0]['name'],$r[0]['email'],Role::tryFrom($r[0]['role']),ActivateUser::tryFrom($r[0]['activate_user']),ActiveEmail::tryFrom($r[0]['activate_email']));
            return $users;
    }

    public function selectUserByDay($day) :array|null
    {
        $stmt = $this->sql->prepare("SELECT * from cadastros ,
        to_char(date, 'MM-DD') as day where day = :day and activated_email = 'sim' and activated_member = 'sim' order by name");
        $stmt->bindValue(":day",$day);
        $stmt->execute();
        $r=$stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        return $r;
   
    }
    
}