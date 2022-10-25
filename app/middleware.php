<?php

declare(strict_types=1);

use App\Middleware\ExceptionMiddleware;
use App\Middleware\SessionMiddleware;
use Psr\Log\LoggerInterface;
use Slim\App;

return function (App $app) {
    $app->add(ExceptionMiddleware::class);
    $app->add(SessionMiddleware::class);
};
