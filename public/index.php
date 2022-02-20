<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

// подключаем Composer
require dirname(__DIR__).'/vendor/autoload.php';

// создаём объект приложения
$app = AppFactory::create();


// http://demo/slim1/
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('Home page');
    return $response;
});

// http://demo/slim1/hello
$app->get('/hello', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('Hello world!');
    return $response;
});

// запускаем приложение
$app->run();

# end of file