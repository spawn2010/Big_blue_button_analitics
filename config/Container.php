<?php

use BigBlueButton\BigBlueButton;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Src\DataBase;
use function DI\autowire;

return array(
    DataBase::class => autowire()
        ->constructorParameter('params', [
            'dbname' => getenv('DATABASE_NAME'),
            'user' => getenv('DATABASE_USERNAME'),
            'password' => getenv('DATABASE_PASSWORD'),
            'host' => getenv('DATABASE_HOST'),
            'driver' => getenv('DATABASE_DRIVER'),
        ]),
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('general');
        $fileHandler = new StreamHandler(dirname(__DIR__) . '/var/log/app.log', Logger::INFO);
        $logger->pushHandler($fileHandler);
        return $logger;
    }),
    BigBlueButton::class => DI\factory(function () {
        return new BigBlueButton(getenv('API_BASEURL'),getenv('API_SECRET'));
    })
);