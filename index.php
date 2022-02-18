<?php

phpinfo();
$dsn = "mysql:host=db;dbname=test_db";

try {
    $pdo = new PDO($dsn, 'root', 'root');
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}

if ($pdo){
    echo 1;
}