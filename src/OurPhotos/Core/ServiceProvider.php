<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 14:24
 */

namespace OurPhotos\Core;

use OurPhotos\Core\Controller\GalleryController;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @package OurPhotos\Core
 */
class ServiceProvider implements ServiceProviderInterface
{
    const MODULE_PREFIX = 'our_photos.core';


    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $this->addRoutes($app);
        $this->addControllers($app);

    }


    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // Nothing here (yet)
    }


    /**
     * @param Application $app
     */
    protected function addRoutes(Application $app)
    {
        /** @var \Silex\ControllerCollection $gallery */
        $gallery = $app['controllers_factory'];

        $gallery->get('/', self::MODULE_PREFIX . '.controller.gallery:listAction');
        $gallery->post('/', self::MODULE_PREFIX . '.controller.gallery:createAction');
        $gallery->get('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:viewAction');
        $gallery->put('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:updateAction');
        $gallery->delete('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:deleteAction');

        $app->mount('/galleries', $gallery);
    }


    protected function addControllers(Application $app)
    {
        // Gallery Controller
        $app[self::MODULE_PREFIX . '.controller.gallery'] = $app->share(
            function ($app) {
                return new GalleryController($app['orm.em']);
            }
        );
    }
}