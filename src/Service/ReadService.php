<?php

namespace App\Service;

use App\Dao\AttendeeDao;
use App\Dao\LogDao;
use App\Dao\MeetingDao;
use App\Exception\NotFoundAttendeeByIdException;
use App\Exception\NotFoundMeetingCollectionException;
use App\Exception\NotFoundModeratorException;
use App\Exception\NotFoundMeetingByIdException;
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
    public function getMeetingsInfoByParam($param)
    {
        $meetings = $this->getMeetingsByParam("$param");
        $countMeetings = count($meetings);
        $countAttendees = $this->getMaxUsersByMeetingsParam("$param");
        $medianDuration = $this->getMedianDurationByMeetingsParam("$param order by duration");

        return [
            'meetings' => $meetings,
            'countMeetings' => $countMeetings,
            'countAttendees' => $countAttendees,
            'medianDuration' => $medianDuration
        ];
    }

    /**
     * @throws Exception
     */
    public function getAllMeetingsInfo(): array
    {
        $data = [];
        foreach ($this->getMeetings() as $item){
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
        $meeting = $this->getMeetingById($id);
        $moderators = $this->getModerators($meeting['internalMeetingId']);

        return [
            'meeting' => $meeting,
            'moderators' => $moderators,
        ];
    }

    /**
     * @throws Exception
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
        try {
            $result = $this->meetingDao->getCollection();
            if (!$result){
                throw new NotFoundMeetingCollectionException();
            }
        } catch (NotFoundMeetingCollectionException $exception) {
            $exception->getError();
            die();
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function getMeetingById($id): array
    {
        try {
            $result = $this->meetingDao->getById($id);
            if (!$result){
                throw new NotFoundMeetingByIdException();
            }
        } catch (NotFoundMeetingByIdException $exception) {
            $exception->getError("id = $id");
            die();
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function getAttendeeById($id): array
    {
        try {
            $result = $this->attendeeDao->getById($id);
            if (!$result){
                throw new NotFoundAttendeeByIdException();
            }
        } catch (NotFoundAttendeeByIdException $exception) {
            $exception->getError("id = $id");
            die();
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function getMeetingsByParam($params): array
    {
        try {
            $result = $this->meetingDao->getCollectionByParam($params);
            if (!$result){
                throw new NotFoundMeetingCollectionException();
            }
        } catch (NotFoundMeetingCollectionException $exception) {
            $exception->getError($params);
            die();
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function getMedianDurationByMeetingsParam($params)
    {
        $meetings = $this->getMeetingsByParam($params);
        $medianDuration = (count($meetings)+1)/2;
        return $meetings[$medianDuration - 1]['duration'];
    }

    /**
     * @throws Exception
     */
    public function getMaxUsersByMeetingsParam($params)
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
    public function getModerators($internalMeetingId)
    {
        try {
            $moderators = [];
            $meeting =  $this->logDao->getByInternalMeetingId($internalMeetingId);
            if (!$meeting){
                throw new NotFoundMeetingByIdException();
            }
            foreach ($meeting as $item){
                $user = $this->attendeeDao->getByInternalId($item['userId']);
                if ($user['role'] === 'MODERATOR'){
                   $moderators[] = $user;
                }
            }
            if (!$moderators){
                throw new NotFoundModeratorException();
            }
            return $moderators;
        }catch (NotFoundModeratorException $exception){
            return null;
        }catch (NotFoundMeetingByIdException $exception){
            $exception->getError("internalId = $internalMeetingId");
            die();
        }

    }

    /**
     * @throws Exception
     */
    public function getMeetingsByAttendee($attendeeInternalId): ?array
    {
        try {
            $meetings = [];
            $user = $this->logDao->getByUserId($attendeeInternalId);
            if(!$user){
                throw new NotFoundAttendeeByIdException();
            }
            foreach ($user as $item){
                $meetings = $this->meetingDao->getByInternalMeetingId($item['meetingId']);
            }
            if(!$meetings){
                throw new NotFoundMeetingByIdException();
            }
            return $meetings;
        }catch (NotFoundAttendeeByIdException $exception){
            $exception->getError("internalId = $attendeeInternalId");
            die();
        }catch (NotFoundMeetingByIdException $exception){
            return null;
        }
    }

}