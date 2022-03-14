<?php

declare(strict_types=1);

use App\Action\ListAction;
use App\Action\MeetingAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/', \App\Action\IndexAction::class);

    $app->get('/user/{id}', \App\Action\UserAction::class);

    $app->group('/meetings', function (Group $group) {
        $group->get('', ListAction::class);
        $group->get('/{id}', MeetingAction::class);
    });
};
