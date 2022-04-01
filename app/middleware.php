<?php

declare(strict_types=1);

use App\Middleware\ExceptionMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(ExceptionMiddleware::class);

};
