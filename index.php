<?php

const BASE_DIR = __DIR__;

use App\Middleware\LogMiddleware;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions('config/Container.php');

$container2 = $builder->build();
AppFactory::setContainer($container2);

$app = AppFactory::create();
$app->add(LogMiddleware::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true, $container2->get(LoggerInterface::class));

require __DIR__.'/config/Routes.php';

$app->run();