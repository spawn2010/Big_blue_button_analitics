<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use DI\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// подключаем Composer
require dirname(__DIR__).'/vendor/autoload.php';


// Создание контейнера PHP-DI
$container = new Container();

// Создаём объект приложения Slim и передаём в него контейнер
AppFactory::setContainer($container);
$app = AppFactory::create();

// Создадим объект для логирования через контейнер
$container->set('logger', function () {
    $log = new Logger('general');
    $log->pushHandler(new StreamHandler(dirname(__DIR__) . '/var/log/app.log', Logger::INFO));

    return $log;
});

var_dump($app->getContainer());
$app->addErrorMiddleware(false, false, false);

// создадим свой Middleware1
$myMiddleware1 = function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write(' myMiddleware1 ');
    return $response;
};

// создадим свой Middleware2
$myMiddleware2 = function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write(' myMiddleware2');
    return $response;
};

// логирование всех запросов
$logMiddleware = function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($app) {

    $container = $app->getContainer();

    // если установлен лог, то пишем в него текущий url-путь
    if ($container->has('logger'))
        $container->get('logger')->info($request->getUri()->getPath());

    $response = $handler->handle($request);

    return $response;
};

// добавим его в приложение
$app->add($myMiddleware2);
$app->add($myMiddleware1);
$app->add($logMiddleware);

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