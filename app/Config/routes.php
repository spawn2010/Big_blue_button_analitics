<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/', \App\Modules\Home\Home::class);

$app->get('/hello', \App\Modules\Home\Home::class)->add(\App\Middleware\AfterMiddleware::class);