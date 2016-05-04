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
    const SERVICE_ROUTING_CONVERTER_GALLERY = 'core.routing.parameter_converter.gallery';
    const CONTROLLER_GALLERY                = 'core.controller.gallery';


    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->addRoutingParameterConverters($app);
        $this->addControllers($app);
        $this->addRoutes($app);

    }


    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // Nothing here (yet)
    }


    /**
     * Adds core module services...
     *
     * - our_photos.core.routing.converter.gallery
     *
     * @param Application $app
     */
    protected function addRoutingParameterConverters(Application $app)
    {
        // core.routing.parameter_converter.gallery
        $app[self::SERVICE_ROUTING_CONVERTER_GALLERY] = $app->share(
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
        $app[self::CONTROLLER_GALLERY] = $app->share(
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

        $gallery->get('/', 'core.controller.gallery:listAction')
                ->bind('core.gallery:list');
        $gallery->post('/', 'core.controller.gallery:createAction')
                ->bind('core.gallery:create');
        $gallery->get('/{gallery}', 'core.controller.gallery:viewAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind('core.gallery:view');
        $gallery->put('/{gallery}', 'core.controller.gallery:updateAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind('core.gallery:update');
        $gallery->delete('/{gallery}', 'core.controller.gallery:deleteAction')
                ->assert('gallery', '([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}){1}')
                ->convert('gallery', $this->getServiceMethodId(self::SERVICE_ROUTING_CONVERTER_GALLERY, 'convert'))
                ->bind('core.gallery:delete');

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
        return sprintf('%s:%s', $service, $method);
    }
}