<?php

namespace App\Dao;

use App\Adapter\AttendeeAdapter;
use App\Adapter\MeetingAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class LogDao
{
    private Connection $connection;
    private $meeting;
    private $attendee;

    public function __construct(Connection $connection, $meeting, $attendee)
    {
        $this->connection = $connection;
        $this->meeting = $meeting;
        $this->attendee = $attendee;
    }

    /**
     * @throws Exception
     */
    public function insert()
    {
        try {
            $this->connection->createQueryBuilder()
                ->insert('logs')
                ->values([
                    'userId' => '?',
                    'meetingId' => '?',
                ])
                ->setParameters([
                    0 => $this->attendee->getInternalId(),
                    1 => $this->meeting->getInternalMeetingId(),
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    public function getByMeetingId($meetingId): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('logs')
            ->where("meetingId = ?")
            ->setParameter(0, $meetingId)->fetchAllAssociative();
    }

}