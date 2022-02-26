<?php

namespace App\Domain;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\DataBase;

class Domain
{
    private $connection;

    public function __construct(DataBase $container)
    {
        $this->connection = $container->getConnect();
    }

    public function getBody($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM test WHERE id = :id');
        $statement->execute([
            'id' => $id
        ]);
        $result = $statement->fetchAll();
        $body = strval($result[0]['info']);
        return $body;
    }
}