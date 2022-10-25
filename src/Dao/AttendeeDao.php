<?php

namespace App\Dao;

use App\Entity\Attendee;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class AttendeeDao
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function insert(Attendee $attendee): void
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
                    0 => $attendee->getFullName(),
                    1 => $attendee->getInternalId(),
                    2 => $attendee->getRole(),
                ])
                ->executeQuery();
        } catch (Exception $e) {
            throw new Exception((string)$e);
        }
    }

    /**
     * @throws Exception
     */
    public function getByInternalId($internalId): array|bool
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("internalId = ?")
            ->setParameter(0, $internalId)->fetchAssociative();
    }

    /**
     * @throws Exception
     */
    public function getById($id): array|bool
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where("id = ?")
            ->setParameter(0, $id)->fetchAssociative();
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