<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Silex\Application;

define('PROJECT_ROOT', __DIR__);
define('WEB_DIR', PROJECT_ROOT . '/web');
define('APP_DIR', PROJECT_ROOT . '/app');
define('CACHE_DIR', APP_DIR . '/cache');
define('CONFIG_DIR', APP_DIR . '/config');
define('SRC_DIR', PROJECT_ROOT . '/src');
define('VENDOR_DIR', PROJECT_ROOT . '/vendor');
define('TESTS_DIR', PROJECT_ROOT . '/tests');

$loader = require_once VENDOR_DIR . '/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new Application();

require_once CONFIG_DIR . '/services.php';
require_once CONFIG_DIR . '/middleware.php';

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