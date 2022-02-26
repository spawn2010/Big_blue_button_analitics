<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @var $app
 */

$app->get('/', function (RequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('hello-app');
    return $response;
});

$app->get('/{id}', \App\Action\ActionId::class);