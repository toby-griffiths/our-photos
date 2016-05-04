<?php

namespace OurPhotos\Core\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Gallery Repository
 */
class GalleryRepository extends EntityRepository
{
    /**
     * Creates a new Gallery entity and optionally populates it with the given data
     *
     * @param array $data
     *
     * @return Gallery
     */
    public function create(array $data = [])
    {
        $gallery = new Gallery();

        $this->populate($gallery, $data);

        return $gallery;
    }


    /**
     * Updates the given gallery entity with the given data
     *
     * @param Gallery $gallery
     * @param array   $data
     */
    public function populate(Gallery $gallery, array $data)
    {
        throw new \OutOfBoundsException(sprintf('%s::%s() not finished yet', __CLASS__, __METHOD__));
    }
}
