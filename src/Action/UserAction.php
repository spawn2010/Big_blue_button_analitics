<?php

namespace App\Action;

use App\Exception\NotFoundAttendeeException;
use App\Exception\NotFoundMeetingException;
use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;

class UserAction
{
    private ReadService $readService;
    private Messages $flash;

    public function __construct(ReadService $readService, Messages $flash)
    {
        $this->readService = $readService;
        $this->flash = $flash;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $this->readService->getAttendeeInfoById($args['id']);
        } catch (NotFoundAttendeeException $e) {
            $this->flash->addMessage('attendee', 'Пользователь с id =' . $args['id'] . 'не найден');
        } catch (NotFoundMeetingException $e) {
            $this->flash->addMessage('attendeeMeetings', 'Конференции пользователя не найдены');
        }

        $response->getBody()->write('<img src="https://sun9-36.userapi.com/impf/w9BTOq2jyEsmuDt79UZyXhug35P7gYvnEN8LsA/RYuzWAk2fwo.jpg?size=1280x717&quality=96&sign=eb220a7814e1daab7971cc510a0cd8a7&type=album" width=50% height=50%>');
        return $response;
    }
}