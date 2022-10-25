<?php

namespace App\Action;

use App\Exception\NotFoundMeetingException;
use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;
use Twig\Environment;

class MeetingAction
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
        $data = $this->readService->getMeetingInfoById($args['id']);
        $body = $this->view->render('info.twig',['data' => $data]);
        $response->getBody()->write($body);
        return $response;
    }

}