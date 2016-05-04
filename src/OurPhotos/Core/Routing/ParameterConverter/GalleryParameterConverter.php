<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 15:15
 */

namespace OurPhotos\Core\Routing\ParameterConverter;

use Doctrine\ORM\EntityManager;
use OurPhotos\Core\Entity\Gallery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Converts gallery ID parameters to Gallery objects
 *
 * @package OurPhotos\Core
 */
class GalleryParameterConverter
{
    /**
     * @var EntityManager
     */
    protected $em;


    /**
     * GalleryParameterConverter constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Converts an $id string to the related Gallery entity
     *
     * @param string $id
     *
     * @return Gallery
     *
     * @throws NotFoundHttpException if gallery with the ID $id is not found
     */
    public function convert($id)
    {
        $gallery = $this->em->find('OurPhotos:Gallery', $id);

        if (is_null($gallery)) {
            throw new NotFoundHttpException(sprintf('Gallery %s not found', $id));
        }

        return $gallery;
    }
}