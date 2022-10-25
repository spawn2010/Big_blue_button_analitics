<?php

namespace App\Action;

use App\Service\WriteService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RefreshAction
{
    private WriteService $writeService;

    public function __construct(WriteService $writeService)
    {
        $this->writeService = $writeService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->writeService->refresh();
        $response->getBody()->write('данный Action будет взаимодействовать с WriteService');
        return $response;
    }
}