<?php

namespace App\Dao;

use App\Entity\Attendee;
use App\Entity\Meeting;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class LogDao
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function insert(Attendee $attendee, Meeting $meeting): void
    {
        try {
            $this->connection->createQueryBuilder()
                ->insert('logs')
                ->values([
                    'userId' => '?',
                    'meetingId' => '?',
                ])
                ->setParameters([
                    0 => $attendee->getInternalId(),
                    1 => $meeting->getInternalMeetingId(),
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function getByInternalMeetingId($meetingId): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('logs')
            ->where("meetingId = ?")
            ->setParameter(0, $meetingId)->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getByUserId($internalUserId): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('logs')
            ->where("userId = ?")
            ->setParameter(0, $internalUserId)->fetchAllAssociative();
    }

}