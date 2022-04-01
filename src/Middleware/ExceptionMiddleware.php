<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\BaseException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages;


class ExceptionMiddleware implements Middleware
{

    private Messages $flash;

    public function __construct(Messages $messages)
    {
        $this->flash = $messages;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (BaseException $e) {
            var_dump($e->getException());
            return $handler->handle($request);
        }
    }
}