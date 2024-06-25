<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Birthday\BirthdayRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Birthday\InBirthdayRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        BirthdayRepository::class => \DI\autowire(InBirthdayRepository::class),


    ]);
};
