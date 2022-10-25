<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages;

class SessionMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */

    private Messages $flash;

    public function __construct(Messages $messages)
    {
        $this->flash = $messages;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Change flash message storage
        $this->flash->__construct($_SESSION);

        return $handler->handle($request);
    }
}