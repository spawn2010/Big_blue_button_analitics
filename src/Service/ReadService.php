<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\MeetingDao;
use Doctrine\DBAL\Connection;

class ReadService
{
    private Connection $connection;
    private MeetingDao $meetingDao;
    private AttendeeDao $attendeeDao;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->meetingDao = new MeetingDao($this->connection);
        $this->attendeeDao = new AttendeeDao($this->connection);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getMeetingsInfo(): array
    {
        return $this->meetingDao->getCollection();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getMeetingInfo($internalMeetingId): array
    {
       return $this->meetingDao->getById($internalMeetingId);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getAttendeeInfo($internalId): array
    {
        return $this->attendeeDao->getById($internalId);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getAttendeesInfo(): array
    {
        return $this->attendeeDao->getCollection();
    }


}