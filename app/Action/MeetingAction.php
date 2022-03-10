<?php

namespace App\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Template;

class MeetingAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $tmpl = Template::getTmpl(BASE_DIR.'/templates/meeting.php',['body' => 'meetengInfo']);
        $response->getBody()->write($tmpl);
        return $response;
    }

}