<?php

namespace App\Exception;

class NotFoundMeetingByIdException extends \Exception
{
    public function getError($id): bool
    {
        echo "Конференция с $id не cуществует";
        return false;
    }
}