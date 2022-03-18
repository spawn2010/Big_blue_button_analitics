<?php

namespace App\Dao;

use App\Adapter\AttendeeAdapter;
use App\Adapter\MeetingAdapter;
use BigBlueButton\Core\Attendee;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class AttendeeDao
{
    private Connection $connection;
    private $attendee;

    public function __construct(Connection $connection, $attendee = '')
    {
        $this->connection = $connection;
        $this->attendee = $attendee;
    }

    /**
     * @throws Exception
     */
    public function insert()
    {
        try {
            $this->connection->createQueryBuilder()
                ->insert('users')
                ->values([
                    'fullName' => '?',
                    'internalId' => '?',
                    'role' => '?',
                ])
                ->setParameters([
                    0 => $this->attendee->getFullName(),
                    1 => $this->attendee->getInternalId(),
                    2 => $this->attendee->getRole(),
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function getById($internalId): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("internalId = ?")
            ->setParameter(0, $internalId)->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getCollection(): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->fetchAllAssociative();
    }
}