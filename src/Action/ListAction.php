<?php

namespace App\Action;

use App\Domain\MeetingsDomain;
use App\Service\ReadService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Template;

class ListAction
{
    private ReadService $readService;

    public function __construct(ReadService $readService)
    {
        $this->readService = $readService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write('<img src="https://sun9-52.userapi.com/impf/ApXVwrkaiZw1n39e7ZZQ7ct3R-qVNcdhODf7zw/rAJ6_tuM3sk.jpg?size=1280x722&quality=96&sign=987a6b673bb121dd806c6da71115b6f8&type=album" width=100% height=100%>');
        return $response;
    }
}