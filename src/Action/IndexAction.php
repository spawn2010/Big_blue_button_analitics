<?php

namespace App\Action;

use App\Service\ReadService;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
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
        $meetings = $this->readService->getMeetingsByParam('running = 1');
        $countMeetings = count($this->readService->getMeetingsByParam('running = 1'));
        $countAttendees = $this->readService->getMaxUsersByParam('running = 1');
        $medianDuration = $this->readService->getMedianDurationByParam('running = 1 order by duration');
        $data = [
            'meetings' => $meetings,
            'countMeetings' => $countMeetings,
            'countAttendees' =>  $countAttendees,
            'medianDuration' => $medianDuration
        ];
        $response->getBody()->write('<img src="https://sun9-21.userapi.com/impf/y2DXEIn3kevJGSUiPZ_r_BFNbrgmkCgZ_5LewA/yqlhPratQxY.jpg?size=1280x718&quality=96&sign=4346a6b52783a0c84c220dbb8d02846a&type=album" width=50% height=50%>');
        return $response;
    }
}
