<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;

define('PROJECT_ROOT', __DIR__);
define('WEB_DIR', PROJECT_ROOT . '/web');
define('APP_DIR', PROJECT_ROOT . '/app');
define('VENDOR_DIR', PROJECT_ROOT . '/vendor');
define('TESTS_DIR', PROJECT_ROOT . '/tests');

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();

require_once __DIR__ . '/app/services.php';
require_once __DIR__ . '/app/middleware.php';

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

return $app;