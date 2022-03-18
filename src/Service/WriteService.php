<?php

namespace App\Service;

use App\Adapter\AttendeeAdapter;
use App\Adapter\MeetingAdapter;
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
            $meeting = (new MeetingAdapter($meetingFromApi))->toEntity();
            $meetingDao = new MeetingDao($this->connection, $meeting);
            foreach ($meetingFromApi->getAttendees() as $attendeeFromApi) {
                $attendee = (new AttendeeAdapter($attendeeFromApi))->toEntity();
                $attendeeDao = new AttendeeDao($this->connection, $attendee);
                $logDao = new LogDao($this->connection, $meeting, $attendee);
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