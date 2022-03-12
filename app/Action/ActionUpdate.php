<?php

namespace App\Action;

use App\Domain\IndexDomain;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
        $body = $this->container->get(IndexDomain::class)->refresh();
        $tmpl = Template::getTmpl(BASE_DIR.'/templates/user.php',['body' => $body]);
        $response->getBody()->write($tmpl);
        return $response;
    }
}