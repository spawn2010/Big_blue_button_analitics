<?php

namespace App\Action;

use App\Domain\MeetingsDomain;
use BigBlueButton\BigBlueButton;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Template;

class IndexAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $this->container->get(MeetingsDomain::class)->getMeetings();
        $tmpl = Template::getTmpl(BASE_DIR.'/templates/index.php',['body' => $body]);
        $response->getBody()->write($tmpl);
        return $response;
    }
}