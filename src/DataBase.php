<?php

namespace Src;

use InvalidArgumentException;
use PDO;
use PDOException;

class DataBase
{
    private PDO $connect;

    public function __construct($dsn, $username, $password)
    {
        try {
            $this->connect = new PDO($dsn, $username, $password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function getConnect(): PDO
    {
        return $this->connect;
    }
}