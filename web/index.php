<?php

use Silex\Provider\ServiceControllerServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application();

require_once __DIR__ . '/../src/services.php';
require_once __DIR__ . '/../src/middleware.php';

// Enabled controllers as services
$app->register(new ServiceControllerServiceProvider());

/**
 * /galleries endpoints
 */
/** @var \Silex\ControllerCollection $galleriesEndpoints */
$galleriesEndpoints = $app['controllers_factory'];
$galleriesEndpoints->get('/', 'our_photos.core.controller.gallery:listAction');
$galleriesEndpoints->post('/', 'our_photos.core.controller.gallery:createAction');
$galleriesEndpoints->put('/', 'our_photos.core.controller.gallery:updateAction');
$galleriesEndpoints->delete('/', 'our_photos.core.controller.gallery:deleteAction');

$app->mount('/galleries', $galleriesEndpoints);

$app->get(
    '/hello/{who}',
    function ($who) {
        return compact('who');
    }
);

$app->run();