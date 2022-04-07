<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\BaseException;
use App\Exception\NotFoundAttendeeException;
use App\Exception\NotFoundMeetingCollectionException;
use App\Exception\NotFoundMeetingException;
use App\Exception\NotFoundModeratorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
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
        $response = new \Slim\Psr7\Response();
        try {
            return $handler->handle($request);
        } catch (NotFoundAttendeeException $e) {
            $this->flash->addMessage('error',$e->getException());
            $response->withHeader('location','/');
        } catch (NotFoundMeetingCollectionException $e){
            $this->flash->addMessage('error',$e->getException());
        } catch (NotFoundMeetingException $e){
            $this->flash->addMessage('error',$e->getException());
        } catch (NotFoundModeratorException $e){
            $this->flash->addMessage('error',$e->getException());
        }
        var_dump($response->getHeaders());
        var_dump($_SESSION);
        return $response;

    }
}