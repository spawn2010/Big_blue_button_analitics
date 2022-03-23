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
    private $meetingDao;
    private $attendeeDao;
    private $logDao;

    public function __construct(BigBlueButton $meetings, MeetingDao $meetingDao, AttendeeDao $attendeeDao, LogDao $logDao)
    {
        $this->meetings = $meetings->getMeetings()->getMeetings();
        $this->meetingDao = $meetingDao;
        $this->attendeeDao = $attendeeDao;
        $this->logDao = $logDao;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function refresh()
    {
        foreach ($this->meetings as $meetingFromApi) {

            $meeting = (new MeetingAdapter($meetingFromApi))->toEntity();

            foreach ($meetingFromApi->getAttendees() as $attendeeFromApi) {

                $attendee = (new AttendeeAdapter($attendeeFromApi))->toEntity();

                if (!$this->attendeeDao->getById($attendeeFromApi->getUserId())) {
                    $this->attendeeDao->insert($attendee);
                }

                if (!$this->logDao->getByMeetingId($meetingFromApi->getInternalMeetingId())) {
                    $this->logDao->insert($attendee,$meeting);
                }
            }

            if ($this->meetingDao->getById($meetingFromApi->getInternalMeetingId())) {
                $this->meetingDao->update($meeting);
                continue;
            }

            $this->meetingDao->insert($meeting);
        }
    }
}

