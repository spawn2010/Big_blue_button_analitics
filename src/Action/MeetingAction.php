<?php

namespace App\Action;

use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MeetingAction
{
    private ReadService $readService;

    public function __construct(ReadService $readService)
    {
        $this->readService = $readService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $meeting = $this->readService->getMeetingById($args['id']);
        $moderators = $this->readService->getModerators($meeting['internalMeetingId']);
        $data = [
            'meeting' => $meeting,
            'moderators' => $moderators,
        ];
        var_dump($data);
        $response->getBody()->write('<img src="https://sun9-37.userapi.com/impf/SwgPsjdv9bds0ITqhjwBfLhtYABsLTiYX1MUeg/s9amfU-JbnI.jpg?size=1280x718&quality=96&sign=5bc34071fb36e54ac6f786b77d5cf1bf&type=album" width=50% height=50%>');
        return $response;
    }

}