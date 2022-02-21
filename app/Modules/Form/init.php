<?php
$app->get('/form', \App\Modules\Form\FormShow::class);
$app->post('/form', \App\Modules\Form\FormPost::class);