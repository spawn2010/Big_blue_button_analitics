<?php

namespace App\Exception;

class NotFoundAttendeeByIdException extends \Exception
{
    public function getError($id): bool
    {
        echo "Пользователь с $id не cуществует";
        return false;
    }
}