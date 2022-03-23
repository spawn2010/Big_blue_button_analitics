<?php

namespace App\Dao;

use App\Adapter\MeetingAdapter;
use App\Entity\Meeting;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class MeetingDao
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function update($meeting)
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
                    0 => $meeting->getRunning(),
                    1 => $meeting->getDuration(),
                    2 => $meeting->getMaxUsers(),
                    3 => $meeting->getEndTime(),
                    4 => $meeting->getInternalMeetingId()
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function insert(Meeting $meeting): void
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
                    0 => $meeting->getMeetingName(),
                    1 => $meeting->getMeetingId(),
                    2 => $meeting->getInternalMeetingId(),
                    3 => $meeting->getStartTime(),
                    4 => $meeting->getCreationDate(),
                    5 => $meeting->getRunning(),
                    6 => $meeting->getCreationTime(),
                    7 => $meeting->getEndTime(),
                    8 => $meeting->getDuration(),
                    9 => $meeting->getMaxUsers()
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
    public function getCollection(): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetings')
            ->fetchAllAssociative();
    }
}