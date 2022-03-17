<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use BigBlueButton\BigBlueButton;
use Doctrine\DBAL\Connection;

class WriteService
{
    private $meetings;
    private Connection $connection;

    public function __construct(Connection $connection, BigBlueButton $meetings)
    {
        $this->connection = $connection;
        $this->meetings = $meetings->getMeetings()->getMeetings();

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function refresh()
    {
        foreach ($this->meetings as $meetingFromApi) {
            $meetingDao = new MeetingDao($this->connection, $meetingFromApi);
            foreach ($meetingFromApi->getAttendees() as $attendeeFromApi) {
                $attendeeDao = new AttendeeDao($this->connection, $attendeeFromApi);
                $logDao = new LogDao($this->connection, $meetingFromApi, $attendeeFromApi);
                if (!$attendeeDao->getById($attendeeFromApi->getUserId())) {
                    $attendeeDao->insert();
                }
                if (!$logDao->getByMeetingId($meetingFromApi->getInternalMeetingId())) {
                    $logDao->insert();
                }
            }
            if ($meetingDao->getById($meetingFromApi->getInternalMeetingId())) {
                $meetingDao->update();
                continue;
            }
            $meetingDao->insert();
        }
    }
}