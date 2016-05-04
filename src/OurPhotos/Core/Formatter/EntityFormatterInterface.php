<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 16:20
 */

namespace OurPhotos\Core\Formatter;

use OurPhotos\Core\Entity\EntityInterface;

/**
 * Interface for entity specific formatter classes
 *
 * @package OurPhotos\Core
 */
interface EntityFormatterInterface
{
    /**
     * Should return the entity class name that this formatter supports
     *
     * @return string
     */
    public function supportedEntity();


    /**
     * Should format the given entity ready for rendering
     *
     * @param EntityInterface $entity
     *
     * @return mixed Return data will depend on format required.  Only JSON supported at present.
     */
    public function format(EntityInterface $entity);
}