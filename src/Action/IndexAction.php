<?php

namespace App\Action;

use App\Exception\NotFoundMeetingCollectionException;
use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;

class IndexAction
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

        $data = $this->readService->getMeetingsInfoByParam(['running', '1']);
        var_dump($data);
        var_dump($this->flash->getMessage('error'));
        $response->getBody()->write('<img src="https://sun9-21.userapi.com/impf/y2DXEIn3kevJGSUiPZ_r_BFNbrgmkCgZ_5LewA/yqlhPratQxY.jpg?size=1280x718&quality=96&sign=4346a6b52783a0c84c220dbb8d02846a&type=album" width=50% height=50%>');
        return $response;
    }

}
