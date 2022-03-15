<?php

declare(strict_types=1);

use App\Settings\SettingsInterface;
use BigBlueButton\BigBlueButton;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        BigBlueButton::class => DI\factory(function () {
            return new BigBlueButton(getenv('API_BASEURL'),getenv('API_SECRET'));
        }),
        DriverManager::class => DI\factory(function () {
            return DriverManager::getConnection([
                'dbname' => getenv('DATABASE_NAME'),
                'user' => getenv('DATABASE_USERNAME'),
                'password' => getenv('DATABASE_PASSWORD'),
                'host' => getenv('DATABASE_HOST'),
                'driver' => getenv('DATABASE_DRIVER'),
            ]);
        }),
    ]);

};
