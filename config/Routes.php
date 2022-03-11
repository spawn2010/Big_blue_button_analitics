<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @var $app
 */

$app->get('/', \App\Action\IndexAction::class);

$app->get('/meeting', \App\Action\MeetingAction::class);

$app->get('/meetings', \App\Action\MeetingsAction::class);

$app->get('/user', \App\Action\UserAction::class);

$app->get('/update', \App\Action\ActionUpdate::class);
