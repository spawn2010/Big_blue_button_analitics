<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use Doctrine\DBAL\Exception;

class ReadService
{
    private MeetingDao $meetingDao;
    private AttendeeDao $attendeeDao;
    private LogDao $logDao;

    public function __construct(MeetingDao $meetingDao, AttendeeDao $attendeeDao, LogDao $logDao)
    {
        $this->meetingDao = $meetingDao;
        $this->attendeeDao = $attendeeDao;
        $this->logDao = $logDao;
    }

    /**
     * @throws Exception
     */
    public function getMeetings(): array
    {
        return $this->meetingDao->getCollection();
    }

    /**
     * @throws Exception
     */
    public function getMeetingById($id): array
    {
       return $this->meetingDao->getById($id);
    }

    /**
     * @throws Exception
     */
    public function getAttendeeById($id): array
    {
        return $this->attendeeDao->getById($id);
    }

    /**
     * @throws Exception
     */
    public function getAttendees(): array
    {
        return $this->attendeeDao->getCollection();
    }

    /**
     * @throws Exception
     */
    public function getMeetingsByParam($params): array
    {
        return $this->meetingDao->getCollectionByParam($params);
    }

    /**
     * @throws Exception
     */
    public function getMedianDurationByParam($params)
    {
        $meetings = $this->getMeetingsByParam($params);
        $medianDuration = (count($meetings)+1)/2;
        return $meetings[$medianDuration - 1]['duration'];
    }

    /**
     * @throws Exception
     */
    public function getMaxUsersByParam($params)
    {
        $maxUsers = 0;
        $meetengs = $this->getMeetingsByParam($params);
        foreach ($meetengs as $value){
            $maxUsers += ($value['maxUsers']);
        }
        return $maxUsers;
    }

    /**
     * @throws Exception
     */
    public function getModerator($internalMeetingId)
    {
       $res =  $this->logDao->getByInternalMeetingId($internalMeetingId);
       foreach ($res as $item){
           $user = $this->attendeeDao->getByInternalId($item['userId']);
           if ($user['role'] ?? 'VIEWER' === 'MODERATOR'){
               return $user;
           }
       }
    }

    /**
     * @throws Exception
     */
    public function getMeetingsByAttendee($attendeeInternalId): array
    {
        $meetings = [];
        $res = $this->logDao->getByUserId($attendeeInternalId);
        foreach ($res as $item){
            $meetings = $this->meetingDao->getByInternalMeetingId($item['meetingId']);
        }
        return $meetings;
    }

}