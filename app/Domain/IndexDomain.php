<?php

namespace App\Domain;

use BigBlueButton\BigBlueButton;
use Src\DataBase;

class IndexDomain
{
    private array $meetings;
    private \Doctrine\DBAL\Connection $connect;

    public function __construct(BigBlueButton $container,DataBase $connect)
    {
        $this->meetings = $container->getMeetings()->getMeetings();
        $this->connect = $connect->getConnect();
    }

    public function refresh()
    {
       foreach ($this->meetings as $meeting){
           $result = $this->exist($meeting->getInternalMeetingId(),'meetings','internalMeetingId');
           $this->attendee($meeting->getAttendees(),$meeting);
           if ($result){
                $this->meetingUpdate($meeting);
               continue;
           }
           $this->meetingInsert($meeting);
       }
    }

    public function insert($tableName, $arVal, $arParam)
    {
        $this->connect->createQueryBuilder()
            ->insert($tableName)
            ->values($arVal)
            ->setParameters($arParam)
            ->executeQuery();
    }

    public function attendeeInsert($attendee)
    {
        $arVal =[
            'fullName' => '?',
            'internalId' => '?',
            'role' => '?',
        ];
        $arParam = [
            0 => $attendee->getFullName(),
            1 => $attendee->getUserId(),
            2 => $attendee->getRole(),
        ];
        $this->insert('users',$arVal,$arParam);
    }

    public function meetingInsert($meeting)
    {
        $arVal =[
            'meetingName' => '?',
            'meetingId' => '?',
            'internalMeetingId' => '?',
            'startTime' => '?',
            'createDate' => '?',
            'running' => '?',
            'createTime' => '?',
            'endTime' => '?',
            'duration' => '?',
            'maxUsers' => '?',
        ];
        $arParam = [
            0 => $meeting->getMeetingName(),
            1 => $meeting->getMeetingId(),
            2 => $meeting->getInternalMeetingId(),
            3 => $meeting->getStartTime(),
            4 => $meeting->getCreationDate(),
            5 => $meeting->isRunning(),
            6 => $meeting->getCreationTime(),
            7 => $meeting->getEndTime(),
            8 => $meeting->getDuration(),
            9 => $meeting->getMaxUsers()
        ];
        $this->insert('meetings',$arVal,$arParam);
    }

    public function meetingUpdate($meeting)
    {
        $this->connect->update('meetings',
            ['running' => $meeting->isRunning(),
                'duration' => $meeting->getDuration(),
                'endTime' => $meeting->getEndTime(),
                'maxUsers' => $meeting->getMaxUsers()],
            ['internalMeetingId' => $meeting->getInternalMeetingId()]);
    }

    public function exist($value, $tableName,$param)
    {
        return $this->connect->createQueryBuilder()
            ->select('*')
            ->from($tableName)
            ->where("$param = ?")
            ->setParameter(0,$value)->fetchAllNumeric();
    }

    private function attendee($attendees,$meeting)
    {
        foreach ($attendees as $attendee){
            $attendeeExist = $this->exist($attendee->getUserId(),'users','internalId');
            $logExist =  $this->exist($attendee->getUserId(),'logs','userId');
            if (!$attendeeExist){
                $this->attendeeInsert($attendee);
            }
            if (!$logExist){
                $this->logInsert($attendee->getUserId(),$meeting->getInternalMeetingId());
            }

        }
    }

    private function logInsert($userId,$meetingId)
    {
        $arVal =[
            'userId' => '?',
            'meetingId' => '?'
        ];
        $arParam = [
            0 => $userId,
            1 => $meetingId
        ];
        $this->insert('logs',$arVal,$arParam);
    }

}