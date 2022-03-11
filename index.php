<?php

const BASE_DIR = __DIR__;

use App\Middleware\LogMiddleware;
use BigBlueButton\BigBlueButton;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use DevCoder\DotEnv;

require __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/local.env'))->load();

$builder = new ContainerBuilder();
$builder->addDefinitions('config/Container.php');

$container = $builder->build();
AppFactory::setContainer($container);


$app = AppFactory::create();
$app->add(LogMiddleware::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true, $container->get(LoggerInterface::class));

require __DIR__.'/config/Routes.php';

$app->run();
