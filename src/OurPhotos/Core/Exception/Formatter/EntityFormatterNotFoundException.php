<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 16:35
 */

namespace OurPhotos\Core\Exception\Formatter;


use OurPhotos\Core\Entity\EntityInterface;
use OurPhotos\Core\Exception\CoreModuleException;

/**
 * Thrown when attempt to find formatter for entity fails
 *
 * @package OurPhotos\Core
 */
class EntityFormatterNotFoundException extends CoreModuleException
{
    /**
     * @var string
     */
    protected $entityClass;


    /**
     * @param EntityInterface $entity
     *
     * @return static
     */
    public static function create(EntityInterface $entity)
    {
        $entityClass = get_class($entity);

        $e = new static(sprintf('Unable to find formatter for entity of class %s', $entityClass));

        $e->entityClass = $entityClass;

        return $e;
    }


    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }
}