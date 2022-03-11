<?php

namespace App\Action;

use App\Domain\Domain;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\DataBase;
use Src\Template;

class ActionUpdate
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $this->container->get(DataBase::class)->getConnect();
        $response->getBody()->write('hello');
        return $response;
    }
}