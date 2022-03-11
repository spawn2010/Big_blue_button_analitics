<?php

namespace App\Domain;

use BigBlueButton\BigBlueButton;
use Src\DataBase;

class IndexDomain
{
    private array $meetings;
    private \Doctrine\DBAL\Query\QueryBuilder $queryBuilder;
    private $con;

    public function __construct(BigBlueButton $container,DataBase $connect)
    {
        $this->meetings = $container->getMeetings()->getMeetings();
        $this->queryBuilder = $connect->getConnect()->createQueryBuilder();
        $this->con = $connect->getConnect();

    }


    public function refresh()
    {
       foreach ($this->meetings as $meeting){
           $result = $this->exist($meeting->getInternalMeetingId(),'meetings','internalMeetingID');
           if ($result){
                $this->meetingUpdate($meeting);
               continue;
           }
           $this->meetingInsert($meeting);
       }
    }


    public function insert($tableName, $arVal, $arParam)
    {
        $this->queryBuilder
            ->insert($tableName)
            ->values($arVal)
            ->setParameters($arParam)
            ->executeQuery();
    }

    public function attendeeInsert()
    {

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

    public function logInsert()
    {

    }

    public function attendeeUpdate()
    {

    }


    public function meetingUpdate($meeting)
    {
        $this->con->update('meetings',
            ['running' => $meeting->isRunning(),
                'duration' => $meeting->getDuration(),
                'endTime' => $meeting->getEndTime(),
                'maxUsers' => $meeting->getMaxUsers()],
            ['internalMeetingId' => $meeting->getInternalMeetingId()]);
    }

    public function logUpdate()
    {

    }


    public function exist($value, $tableName,$param)
    {
        return $this->queryBuilder
            ->select('*')
            ->from($tableName)
            ->where("$param = ?")
            ->setParameter(0,$value)->fetchAllAssociative();
    }

}