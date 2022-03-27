<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use App\Exception\NotFoundAttendeeException;
use App\Exception\NotFoundMeetingCollectionException;
use App\Exception\NotFoundMeetingException;
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
    public function getMeetingsInfoByParam($params)
    {
        try {
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
        } catch (NotFoundMeetingCollectionException $e) {
            echo 'Конференции не найдены';
        }
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
     */
    public function getMeetingInfoById($id)
    {
        try {
            $meeting = $this->getMeetingById($id);
            $moderators = $this->getModerators($meeting['internalMeetingId']);
            return [
                'meeting' => $meeting,
                'moderators' => $moderators,
            ];
        } catch (NotFoundMeetingException $exception) {
            echo "Конференции с id = $id не существует";
        }
    }

    /**
     * @throws Exception
     */
    public function getAttendeeInfoById($id)
    {
        try {
            $user = $this->getAttendeeById($id);
            $meetings = $this->getMeetingsByAttendee($user['internalId']);

            return [
                'user' => $user,
                'meetings' => $meetings
            ];
        } catch (NotFoundAttendeeException $e) {
            echo "Пользователя с id = $id не существует";
        } catch (NotFoundMeetingException $e) {
            echo "Пользователь с id = $id не участвовал в конференциях";
        }
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

    /**
     * @throws Exception
     * @throws NotFoundMeetingCollectionException
     */
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
     */
    public function getModerators($internalMeetingId): array
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