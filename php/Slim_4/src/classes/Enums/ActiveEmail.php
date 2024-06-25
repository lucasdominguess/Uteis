<?php
namespace App\classes\Enums;


enum ActiveEmail: string{
    case Ativado = 'sim';
    case Desativado = 'nao';

}