<?php

namespace App\Action;

use _PHPStan_ccec86fc8\Nette\Schema\ValidationException;
use App\Exception\NotFoundMeetingCollectionException;
use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexAction
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
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $this->readService->getMeetingsInfoByParam(['running', '1']);
        $body = $this->view->render('index.html',['data' => $data,'info' => date('d.m.y')]);
        $response->getBody()->write($body);
        return $response;
    }

}
