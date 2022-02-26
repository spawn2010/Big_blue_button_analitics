<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Src\DataBase;
use function DI\autowire;
use function DI\get;

return array(
    DataBase::class => autowire()->constructorParameter('dsn', 'mysql:host=TEST_DB;dbname=TEST')
        ->constructorParameter('username', 'root')
        ->constructorParameter('password', 'root'),
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('general');
        $fileHandler = new StreamHandler(dirname(__DIR__) . '/var/log/app.log', Logger::INFO);
        $logger->pushHandler($fileHandler);
        return $logger;
    }),
);