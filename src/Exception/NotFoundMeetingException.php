<?php

namespace App\Exception;

class NotFoundMeetingException extends BaseException
{
    public function getException()
    {
        $this->exceptionName = NotFoundMeetingException::class;
        return parent::getException(); // TODO: Change the autogenerated stub
    }
}