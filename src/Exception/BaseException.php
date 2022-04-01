<?php

namespace App\Exception;

class BaseException extends \Exception
{
    public $exceptionName;

    public function getException()
    {
        return $this->exceptionName;
    }
}