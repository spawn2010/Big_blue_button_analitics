<?php

namespace App\Dao;

use App\Adapter\MeetingAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class MeetingDao
{
    private Connection $connection;
    private $meeting;

    public function __construct(Connection $connection, $meetingFromApi)
    {
        $this->connection = $connection;
        $this->meeting = (new MeetingAdapter($meetingFromApi))->toEntity();
    }

    /**
     * @throws Exception
     */
    public function update()
    {
        try {
            $this->connection->createQueryBuilder()
                ->update('meetings')
                ->set('running', '?')
                ->set('duration', '?')
                ->set('maxUsers', '?')
                ->set('endTime', '?')
                ->where("internalMeetingId = ?")
                ->setParameters([
                    0 => $this->meeting->getRunning(),
                    1 => $this->meeting->getDuration(),
                    2 => $this->meeting->getMaxUsers(),
                    3 => $this->meeting->getEndTime(),
                    4 => $this->meeting->getInternalMeetingId()
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function insert()
    {
        try {
            $this->connection->createQueryBuilder()
                ->insert('meetings')
                ->values([
                    'meetingName' => '?',
                    'meetingId' => '?',
                    'internalMeetingId' => '?',
                    'startTime' => '?',
                    'createDate' => '?',
                    'running' => '?',
                    'createTime' => '?',
                    'endTime' => '?',
                    'duration' => '?',
                    'maxUsers' => '?',
                ])
                ->setParameters([
                    0 => $this->meeting->getMeetingName(),
                    1 => $this->meeting->getMeetingId(),
                    2 => $this->meeting->getInternalMeetingId(),
                    3 => $this->meeting->getStartTime(),
                    4 => $this->meeting->getCreationDate(),
                    5 => $this->meeting->getRunning(),
                    6 => $this->meeting->getCreationTime(),
                    7 => $this->meeting->getEndTime(),
                    8 => $this->meeting->getDuration(),
                    9 => $this->meeting->getMaxUsers()
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function getById($internalMeetingId): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetings')
            ->where("internalMeetingId = ?")
            ->setParameter(0, $internalMeetingId)->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getMeetingCollection(): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetings')
            ->fetchAllAssociative();
    }
}