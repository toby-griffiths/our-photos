<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Silex\Application();


$app->get('/hello/{who}', function($who) {
    return compact('who');
});

$app->run();