<?php

namespace App\Action;

use App\Domain\Domain;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Template;

class ActionId
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $this->container->get(Domain::class)->getBody($args['id']);
        $tmpl = Template::getTmpl(BASE_DIR.'/templates/templates.php',['body' => $body]);
        $response->getBody()->write($tmpl);
        return $response;
    }
}