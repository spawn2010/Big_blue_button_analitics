<?php
$app->add(\App\Middleware\BeforeMiddleware::class);
$app->add(\App\Middleware\LogMiddleware::class);