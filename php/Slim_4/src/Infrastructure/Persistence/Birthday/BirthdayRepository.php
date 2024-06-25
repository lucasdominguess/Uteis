<?php 
namespace App\Infrastructure\Persistence\Birthday;

use DateTime;

interface BirthdayRepository { 
    

    public function insert(string $table , array $dados) :int ;


    public function delete(int|string $id,string $table ,string|int $params = 'id') :int ;

    public function selectFindAll($table): array |null ;

    public function selectUserOfId(int|string $id,string $table,string|int $params='id') :array |null ;

    public function update(int $id,string $table ,array $dados,string|int $params='id') : int ;

    public function query($date) :array |null ;

    public function selectUserByLogin($login) :array |null ;







}