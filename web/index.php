<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application();

require_once __DIR__ . '/../src/services.php';
require_once __DIR__ . '/../src/middleware.php';


$app->get(
    '/hello/{who}',
    function ($who) {
        return compact('who');
    }
);

$app->run();