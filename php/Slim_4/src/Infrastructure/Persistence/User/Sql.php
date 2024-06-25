<?php
namespace App\Infrastructure\Persistence\User;


class Sql extends \PDO
/**
 * 
 */
    {   
        public function __construct() {
            try {
                global $env;
                //code...
                parent::__construct("{$env['sgbd']}:
                dbname={$env['dbname']};
                host={$env['host']};
                port={$env['port']}",
                $env['user'],
                $env['password']);
            } catch (\PDOException $th) {
                throw new \PDOException('Erro ao conectar banco de dados');
            }
          
        }
        public function selectFindAll($table): \PDOStatement 
        {
            $stmt = $this->prepare("SELECT * from {$table}");
            // $stmt->execute();
            // $r=$stmt->fetchAll(\PDO::FETCH_ASSOC); 
            return $stmt;
        }
        public function selectUserOfId(string|int $id,string $table,string|int $params ='id'): \PDOStatement
        {
            $stmt = $this->prepare("SELECT * from {$table} where $params = :id");
            $stmt->bindValue(":id",$id);
            // $stmt->execute();
            // $r=$stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $stmt;
        }
        public function update(string|int $id,string $table,array $dados =[],string|int $params = 'id') : \PDOStatement
        {
            
            $s = array_keys($dados);
            $t = "$table set";
            
            $c = "update $t";
            $clause = " where $params = :id" ; 

            foreach ($s as $key){
                $c .= ", $key = :{$key}";
            }
            
            $c.=$clause;
            $c= str_replace("set,","set",$c);
            // $c = substr($nome,0,strlen($nome)-1);
            $stmt  = $this->prepare($c);

            foreach ($dados as $key => $value ){
                $stmt->bindvalue(":{$key}",$value);
            }   
            $stmt->bindValue(':id',$id);

            return $stmt ; 
        }
        public function insert(string $table,array $dados = []) : \PDOStatement
        {
            $keys = array_keys($dados);
            $colunas = implode(',', $keys);
            $valores = implode(',', array_map(fn($e)=>":{$e}", $keys));
            $cmd = "INSERT INTO {$table}($colunas)VALUES($valores)";
            $stmt = $this->prepare($cmd);
          
            foreach ($dados as $key => $value) {
              $stmt->bindValue(":{$key}", $value);
         
            }
        
            return $stmt;
          
       }
       public function delete($id,$table,string|int $params = 'id') :\PDOStatement
       {
           $stmt= $this->prepare("DELETE from {$table} where $params = :id");
           $stmt->bindValue(':id',$id);
           return $stmt ; 
       }
    }

