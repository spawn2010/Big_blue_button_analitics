<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @var $container
 */

// Объект для логирования через контейнер
$container->set('logger', function () {
    $log = new Logger('general');
    $log->pushHandler(new StreamHandler(BASE_DIR . 'var/log/app.log', Logger::INFO));

    return $log;
});