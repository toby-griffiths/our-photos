<?php

namespace OurPhotos;

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\DBAL\Types\Type as DoctrineType;
use Doctrine\ORM\EntityManager;
use OurPhotos\Core\ServiceProvider as CoreServiceProvider;
use Ramsey\Uuid\Doctrine\UuidType;
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
                    'type'                         => 'annotation',
                    'use_simple_annotation_reader' => false,
                    'namespace'                    => 'OurPhotos\Core\Entity',
                    'path'                         => SRC_DIR . '/OurPhotos/Core/Entity',
                    'alias'                        => 'OurPhotos',
                ],
            ],
        ],
    ]
);

// Register the Ramsey UUID ID field type
DoctrineType::addType('uuid', UuidType::class);
/** @var EntityManager $em */
$em = $app['orm.em'];
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid', 'uuid');

/**
 * OurPhotos Modules
 */
// Core
$app->register(new CoreServiceProvider());