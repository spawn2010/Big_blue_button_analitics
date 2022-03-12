<?php

namespace Src;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;


class DataBase
{
    private \Doctrine\DBAL\Connection $connect;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function __construct($params)
    {
        try {
            $this->connect = DriverManager::getConnection($params);
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    public function getConnect(): \Doctrine\DBAL\Connection
    {
        return $this->connect;
    }
}