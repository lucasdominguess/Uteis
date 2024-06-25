<?php 
declare(strict_types=1); 
namespace App\Application\Birthday;
use App\Application\Actions\Action;
use App\classes\CreateLogger;
use App\Infrastructure\Persistence\Birthday\BirthdayRepository;
use App\Infrastructure\Persistence\User\Sql;
use App\Infrastructure\Persistence\User\RedisConn;
use voku\helper\AntiXSS;

abstract class BirthdayAction extends Action
{
    public function __construct(
        protected Sql $sql, 
        protected BirthdayRepository $birthdayRepository,
       
        protected CreateLogger $createLogger,
        protected RedisConn $redis,
        protected AntiXSS $antiXSS 

        )
    {
        // parent::__construct($logger);
       
    }
}