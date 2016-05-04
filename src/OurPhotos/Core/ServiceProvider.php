<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 14:24
 */

namespace OurPhotos\Core;

use OurPhotos\Core\Controller\GalleryController;
use OurPhotos\Core\Routing\ParameterConverter\GalleryParameterConverter;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @package OurPhotos\Core
 */
class ServiceProvider implements ServiceProviderInterface
{
    const MODULE_PREFIX                     = 'our_photos.core';
    const SERVICE_ROUTING_CONVERTER_GALLERY = 'routing.converter.gallery';
    const CONTROLLER_GALLERY                = 'controller.gallery';


    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $this->addServices($app);
        $this->addControllers($app);
        $this->addRoutes($app);

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
     * Prefixes a service ID with the module prefix
     *
     * @param string $serviceId
     *
     * @return string
     */
    protected function prefixServiceId($serviceId)
    {
        return sprintf('%s.%s', self::MODULE_PREFIX, $serviceId);
    }


    /**
     * Adds core module services...
     *
     * - our_photos.core.routing.converter.gallery
     *
     * @param Application $app
     */
    protected function addServices(Application $app)
    {
        $app[$this->prefixServiceId(self::SERVICE_ROUTING_CONVERTER_GALLERY)] = $app->share(
            function ($app) {
                return new GalleryParameterConverter($app['orm.em']);
            }
        );
    }


    /**
     * @param Application $app
     */
    protected function addControllers(Application $app)
    {
        // Gallery Controller
        $app[$this->prefixServiceId(self::CONTROLLER_GALLERY)] = $app->share(
            function ($app) {
                return new GalleryController($app['orm.em']);
            }
        );
    }


    /**
     * @param Application $app
     */
    protected function addRoutes(Application $app)
    {
        $this->addGalleryRoutes($app);
    }


    /**
     * @param Application $app
     */
    protected function addGalleryRoutes(Application $app)
    {
        /** @var ControllerCollection $gallery */
        $gallery = $app['controllers_factory'];

        $gallery->get('/', self::MODULE_PREFIX . '.controller.gallery:listAction')
                ->bind(self::MODULE_PREFIX . '.controller.gallery:list');
        $gallery->post('/', self::MODULE_PREFIX . '.controller.gallery:createAction')
                ->bind(self::MODULE_PREFIX . '.controller.gallery:create');
        $gallery->get('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:viewAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind(self::MODULE_PREFIX . '.controller.gallery:view');
        $gallery->put('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:updateAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind(self::MODULE_PREFIX . '.controller.gallery:update');
        $gallery->delete('/{gallery}', self::MODULE_PREFIX . '.controller.gallery:deleteAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind(self::MODULE_PREFIX . '.controller.gallery:delete');

        $app->mount('/galleries', $gallery);
    }


    /**
     * @param string $service
     * @param string $method
     *
     * @return string
     */
    protected function getServiceMethodId($service, $method)
    {
        return sprintf('%s:%s', $this->prefixServiceId($service), $method);
    }
}