<?php

namespace App\Action;

use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;
use Twig\Environment;

class ListAction
{
    private ReadService $readService;
    private Messages $flash;
    private Environment $view;

    public function __construct(ReadService $readService, Messages $flash, Environment $view)
    {
        $this->readService = $readService;
        $this->flash = $flash;
        $this->view = $view;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $this->readService->getAllMeetingsInfo();
        $body = $this->view->render('meetings.twig',['data' => $data]);
        $response->getBody()->write($body);
        return $response;
    }
}