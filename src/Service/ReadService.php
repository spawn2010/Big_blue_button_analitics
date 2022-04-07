<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use App\Exception\NotFoundAttendeeException;
use App\Exception\NotFoundMeetingCollectionException;
use App\Exception\NotFoundMeetingException;
use App\Exception\NotFoundModeratorException;
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
     * @throws NotFoundMeetingCollectionException
     */
    public function getMeetingsInfoByParam($params)
    {
        $meetings = $this->getMeetingsByParam($params);
        $countMeetings = count($meetings);
        $countAttendees = $this->getMaxUsersByMeetings($meetings);
        $medianDuration = $this->getMedianDurationByMeetingsParam($meetings);
        return [
            'meetings' => $meetings,
            'countMeetings' => $countMeetings,
            'countAttendees' => $countAttendees,
            'medianDuration' => $medianDuration
        ];
    }

    /**
     * @throws Exception
     * @throws NotFoundMeetingException
     */
    public function getAllMeetingsInfo(): array
    {
        $data = [];
        foreach ($this->getMeetings() as $item) {
            $item['moderators'] = $this->getModerators($item['internalMeetingId']);
            $data[] = $item;
        }
        return $data;
    }

    /**
     * @throws Exception
     * @throws NotFoundMeetingException
     */
    public function getMeetingInfoById($id)
    {
        $meeting = $this->getMeetingById($id);
        $moderators = $this->getModerators($meeting['internalMeetingId']);
        return [
            'meeting' => $meeting,
            'moderators' => $moderators,
        ];
    }

    /**
     * @throws Exception
     * @throws NotFoundAttendeeException
     * @throws NotFoundMeetingException
     */
    public function getAttendeeInfoById($id)
    {
        $user = $this->getAttendeeById($id);
        $meetings = $this->getMeetingsByAttendee($user['internalId']);

        return [
            'user' => $user,
            'meetings' => $meetings
        ];
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
        $result = $this->meetingDao->getById($id);
        if (!$result) {
            throw new NotFoundMeetingException();
        }

        return $result;
    }

    /**
     * @throws Exception
     * @throws NotFoundAttendeeException
     */
    public function getAttendeeById($id): array
    {
        $result = $this->attendeeDao->getById($id);
        if (!$result) {
            throw new NotFoundAttendeeException();
        }
        return $result;
    }

    /**
     * @throws Exception
     * @throws NotFoundMeetingCollectionException
     */
    public function getMeetingsByParam($params): array
    {
        $result = $this->meetingDao->getCollectionByParam($params);
        if (!$result) {
            throw new NotFoundMeetingCollectionException();
        }

        return $result;
    }

    public function getMedianDurationByMeetingsParam($meetings)
    {
        $medianDuration = (count($meetings) + 1) / 2;
        return $meetings[$medianDuration - 1]['duration'];
    }

    public function getMaxUsersByMeetings($meetings)
    {
        $maxUsers = 0;
        foreach ($meetings as $value) {
            $maxUsers += ($value['maxUsers']);
        }
        return $maxUsers;
    }

    /**
     * @throws Exception
     * @throws NotFoundMeetingException
     * @throws NotFoundModeratorException
     */
    public function getModerators($internalMeetingId): ?array
    {
        $moderators = [];
        $meeting = $this->logDao->getByInternalMeetingId($internalMeetingId);
        if (!$meeting) {
            throw new NotFoundMeetingException();
        }
        foreach ($meeting as $item) {
            $user = $this->attendeeDao->getByInternalId($item['userId']);
            if ($user['role'] === 'MODERATOR') {
                $moderators[] = $user;
            }
        }

        if (!$moderators) {
            return null;
        }

        return $moderators;
    }

    /**
     * @throws Exception
     * @throws NotFoundMeetingException
     * @throws NotFoundAttendeeException
     */
    public function getMeetingsByAttendee($attendeeInternalId): ?array
    {
        $meetings = [];
        $user = $this->logDao->getByUserId($attendeeInternalId);
        if (!$user) {
            throw new NotFoundAttendeeException();
        }
        foreach ($user as $item) {
            $meetings[] = $this->meetingDao->getByInternalMeetingId($item['meetingId']);
        }
        if (!$meetings) {
            throw new NotFoundMeetingException();
        }

        return $meetings;
    }

}