<?php

namespace App\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write('<img src="https://sun9-21.userapi.com/impf/y2DXEIn3kevJGSUiPZ_r_BFNbrgmkCgZ_5LewA/yqlhPratQxY.jpg?size=1280x718&quality=96&sign=4346a6b52783a0c84c220dbb8d02846a&type=album" width=100% height=100%>');
        return $response;
    }
}