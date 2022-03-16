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

    }

    public function getAll(): array
    {

    }
}