<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 16:45
 */

namespace OurPhotos\Core\Formatter\EntityFormatter;


use OurPhotos\Core\Entity\EntityInterface;
use OurPhotos\Core\Entity\Gallery;
use OurPhotos\Core\Formatter\EntityFormatterInterface;

/**
 * Formats Gallery entities
 *
 * @package OurPhotos\Core
 */
class GalleryFormatter implements EntityFormatterInterface
{

    /**
     * Should return the entity class name that this formatter supports
     *
     * @return string
     */
    public function supportedEntity()
    {
        return Gallery::class;
    }


    /**
     * Should format the given entity ready for rendering
     *
     * @param EntityInterface $entity
     *
     * @return mixed Return data will depend on format required.  Only JSON supported at present.
     */
    public function format(EntityInterface $entity)
    {
        /** @var Gallery $gallery */
        $gallery = $entity;

        return [
            'id'    => $gallery->getId(),
            'title' => $gallery->getTitle(),
        ];
    }
}