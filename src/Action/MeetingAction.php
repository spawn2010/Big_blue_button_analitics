<?php

namespace App\Action;

use App\Exception\NotFoundMeetingException;
use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;

class MeetingAction
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
            $data = $this->readService->getMeetingInfoById($args['id']);
        } catch (NotFoundMeetingException $exception) {
            $this->flash->addMessage('meeting', 'Конференция с id =' . $args['id'] . 'не найдена');
        }

        $response->getBody()->write('<img src="https://sun9-37.userapi.com/impf/SwgPsjdv9bds0ITqhjwBfLhtYABsLTiYX1MUeg/s9amfU-JbnI.jpg?size=1280x718&quality=96&sign=5bc34071fb36e54ac6f786b77d5cf1bf&type=album" width=50% height=50%>');
        return $response;
    }

}