<?php

namespace OurPhotos\Core\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccessor;

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
        $resolver = new OptionsResolver();
        $resolver->setDefined(['title']);
        $data = $resolver->resolve($data);

        $propertyAccessor = new PropertyAccessor();

        foreach ($data as $field => $value) {
            $propertyAccessor->setValue($gallery, $field, $value);
        }
    }
}
