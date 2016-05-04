<?php

namespace OurPhotos;

use OurPhotos\Core\Controller\GalleryController;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;

// $app needs to be defined already.
// This should be done in the ../web/index.php routing file
if (!isset($app) || !$app instanceof Application) {
    throw new \RuntimeException('$app needs to be set and an instance of \\Silex\\Application');
}


/**
 * Enable Controller services
 */
$app->register(new ServiceControllerServiceProvider());

/**
 * Gallery Controller
 */
$app['our_photos.core.controller.gallery'] = $app->share(
    function ($app) {
        return new GalleryController();
    }
);