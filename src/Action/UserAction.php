<?php

namespace App\Action;

use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserAction
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
        $user = $this->readService->getAttendeeById($args['id']);
        $meetings = $this->readService->getMeetingsByAttendee($user['internalId']);
        $data = [
            'user' => $user,
            'meetings' => $meetings
        ];
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $response->getBody()->write('<img src="https://sun9-36.userapi.com/impf/w9BTOq2jyEsmuDt79UZyXhug35P7gYvnEN8LsA/RYuzWAk2fwo.jpg?size=1280x717&quality=96&sign=eb220a7814e1daab7971cc510a0cd8a7&type=album" width=50% height=50%>');
        return $response;
    }
}