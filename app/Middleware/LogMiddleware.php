<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class LogMiddleware
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): Response
    {
        if ($this->container->has('logger'))
            $this->container->get('logger')->info($request->getUri()->getPath());

        $response = $handler->handle($request);

        return $response;
    }
}