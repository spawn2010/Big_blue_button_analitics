<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;

// подключаем Composer
require dirname(__DIR__).'/vendor/autoload.php';

// создаём объект приложения
$app = AppFactory::create();

$app->addErrorMiddleware(false, false, false);

// создадим свой Middleware
$myMiddleware1 = function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write(' myMiddleware1 ');
    return $response;
};

$myMiddleware2 = function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write(' myMiddleware2');
    return $response;
};

// добавим его в приложение
$app->add($myMiddleware2);
$app->add($myMiddleware1);


// http://
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('Home page');
    return $response;
});

// http://hello
$app->get('/hello', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('Hello world!');
    return $response;
});

// всё остальное
$app->get('/{slug}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('This page is ' . $args['slug']);
    return $response;
});




// запускаем приложение
$app->run();

# end of file