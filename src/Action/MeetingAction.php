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
        $response->getBody()->write('<img src="https://sun9-37.userapi.com/impf/SwgPsjdv9bds0ITqhjwBfLhtYABsLTiYX1MUeg/s9amfU-JbnI.jpg?size=1280x718&quality=96&sign=5bc34071fb36e54ac6f786b77d5cf1bf&type=album" width=100% height=100%>');
        return $response;
    }

}