<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 02/05/2016
 * Time: 13:12
 */

namespace OurPhotos\Core\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for /gallery endpoints
 *
 * @package OurPhotos\Core
 */
class GalleryController
{
    /**
     * Lists all galleries
     */
    public function listAction()
    {
        return new JsonResponse(['galleries' => []]);
    }
}