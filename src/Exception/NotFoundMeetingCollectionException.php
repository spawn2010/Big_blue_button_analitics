<?php

namespace App\Exception;


class NotFoundMeetingCollectionException extends \Exception
{
    public function getError($param = 'all'): bool
    {
        echo "Конференции с параметром $param не найдены";
        return false;
    }
}