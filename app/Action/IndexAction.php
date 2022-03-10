<?php

namespace App\Action;

use App\Domain\MeetingsDomain;
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
        $bbb = $this->container->get(MeetingsDomain::class);
        var_dump($bbb->getMeetings());
        $tmpl = Template::getTmpl(BASE_DIR.'/templates/index.php',['body' => 'Index']);
        $response->getBody()->write($tmpl);
        return $response;
    }
}