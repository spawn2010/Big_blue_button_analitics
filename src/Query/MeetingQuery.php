<?php

namespace App\Query;

use App\Entity\Meeting;
use Doctrine\DBAL\Connection;

class MeetingQuery
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function findById($id): Meeting
    {
        $sql = 'select ....';
        $meeting = $this->db->fetchAssociative($sql, $id);

        return Meeting::createFromArray($meeting);
    }

    public function getAll(): array
    {
        $sql = 'select ....';
        $meetings = $this - db->fetchAllAssociative($sql);

        return array_map(static function ($meeting) {
            return Meeting::createFromArray($meeting);
        });
    }
}