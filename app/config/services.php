<?php

namespace OurPhotos;

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use OurPhotos\Core\Controller\GalleryController;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
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
 * Database services
 */
$app->register(
    new DoctrineServiceProvider(),
    [
        'db.options' => [
            'driver' => 'pdo_sqlite',
            'path'   => APP_DIR . '/db/sqlite.db',
        ],
    ]
);

$app->register(
    new DoctrineOrmServiceProvider(),
    [
        'orm.proxies_dir' => CACHE_DIR . '/doctrine/proxies',
        'orm.em.options'  => [
            'mappings' => [
                // Using actual filesystem paths
                [
                    'type'      => 'annotation',
                    'namespace' => 'OurPhotos\Core\Entity',
                    'path'      => SRC_DIR . '/Core/Entity',
                    'alias'     => 'OurPhotos',
                ],
            ],
        ],
    ]
);


/**
 * Gallery Controller
 */
$app['our_photos.core.controller.gallery'] = $app->share(
    function ($app) {
        return new GalleryController();
    }
);