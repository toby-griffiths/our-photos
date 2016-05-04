<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 16:20
 */

namespace OurPhotos\Core\Formatter;

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
     * Should return the format that this formatter outputs
     *
     * @return string
     */
    public function supportedFormat();
}