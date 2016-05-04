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

$loader = require VENDOR_DIR . '/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = new Application();

require_once CONFIG_DIR . '/services.php';
require_once CONFIG_DIR . '/middleware.php';

return $app;