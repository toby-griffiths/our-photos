<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 16:13
 */

namespace OurPhotos\Core\Formatter;


use OurPhotos\Core\Entity\EntityInterface;
use OurPhotos\Core\Exception\Formatter\EntityFormatterNotFoundException;

class Formatter
{
    /**
     * @var array
     */
    protected $formatters;


    /**
     * Initialises $formatters array
     */
    public function __construct()
    {
        $this->formatters = [];
    }


    /**
     * Adds a formatter to the available formatters, ready to convert entities
     *
     * @param EntityFormatterInterface $formatter
     */
    public function registerFormatter(EntityFormatterInterface $formatter)
    {
        $this->formatters[$formatter->supportedEntity()] = $formatter;
    }


    /**
     * @param EntityInterface $entity
     *
     * @return mixed
     */
    public function format(EntityInterface $entity)
    {
        $formatter = $this->getFormatter($entity);

        return $formatter->format($entity);
    }


    /**
     * Finds the relevant formatter for the given entity
     *
     * @param EntityInterface $entity
     *
     * @return EntityFormatterInterface
     *
     * @throws EntityFormatterNotFoundException if no formatter for the given entity registered
     */
    protected function getFormatter(EntityInterface $entity)
    {
        $entityClass = get_class($entity);

        if (!isset($this->formatters[$entityClass])) {
            throw EntityFormatterNotFoundException::create($entity);
        }

        return $this->formatters[$entityClass];
    }
}