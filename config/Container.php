<?php

use BigBlueButton\BigBlueButton;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Src\DataBase;
use function DI\autowire;

return array(
    DataBase::class => autowire()->constructorParameter('dsn', getenv('DATABASE_DSN'))
        ->constructorParameter('username', getenv('DATABASE_USERNAME'))
        ->constructorParameter('password', getenv('DATABASE_PASSWORD')),
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('general');
        $fileHandler = new StreamHandler(dirname(__DIR__) . '/var/log/app.log', Logger::INFO);
        $logger->pushHandler($fileHandler);
        return $logger;
    }),
    BigBlueButton::class => DI\factory(function () {
        return new BigBlueButton(getenv('API_BASEURL'),getenv('API_SECRET'));
    }),
);