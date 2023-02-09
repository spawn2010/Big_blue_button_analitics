<?php

namespace App\Service;

use App\Adapter\AttendeeAdapter;
use App\Adapter\MeetingAdapter;
use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use BigBlueButton\BigBlueButton;
use Doctrine\DBAL\Exception;

class WriteService
{
    private array $meetings;
    private MeetingDao $meetingDao;
    private AttendeeDao $attendeeDao;
    private LogDao $logDao;

    public function __construct(BigBlueButton $meetings, MeetingDao $meetingDao, AttendeeDao $attendeeDao, LogDao $logDao)
    {
        if (getenv('API_BASEURL') == 'yor_base_bigbluebutton_url'){
            $xml = simplexml_load_string(file_get_contents(dirname(__DIR__) . '/../tests/fixtures/get_meeting_info.xml'));
            $this->meetings = [(new \BigBlueButton\Responses\GetMeetingInfoResponse($xml))->getMeeting()];
        }else{
            $this->meetings = $meetings->getMeetings()->getMeetings();
        }

        $this->meetingDao = $meetingDao;
        $this->attendeeDao = $attendeeDao;
        $this->logDao = $logDao;

    }

    /**
     * @throws Exception
     */
    public function refresh(): void
    {
        foreach ($this->meetings as $meetingFromApi) {

            $meeting = (new MeetingAdapter($meetingFromApi))->toEntity();

            foreach ($meetingFromApi->getAttendees() as $attendeeFromApi) {

                $attendee = (new AttendeeAdapter($attendeeFromApi))->toEntity();

                if (!$this->attendeeDao->getByInternalId($attendeeFromApi->getUserId())) {
                    $this->attendeeDao->insert($attendee);
                }

                if ((!$this->logDao->getByInternalMeetingId($meetingFromApi->getInternalMeetingId())) || (!$this->logDao->getByUserId($attendeeFromApi->getUserId()))) {
                    $this->logDao->insert($attendee, $meeting);
                }
            }

            if ($this->meetingDao->getByInternalMeetingId($meetingFromApi->getInternalMeetingId())) {
                $this->meetingDao->update($meeting);
                continue;
            }

            $this->meetingDao->insert($meeting);
        }
    }
}

