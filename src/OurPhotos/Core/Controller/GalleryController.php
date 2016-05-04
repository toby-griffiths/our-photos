<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 02/05/2016
 * Time: 13:12
 */

namespace OurPhotos\Core\Controller;

use Doctrine\ORM\EntityManager;
use OurPhotos\Core\Entity\Gallery;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for /gallery endpoints
 *
 * @package OurPhotos\Core
 */
class GalleryController
{
    /**
     * @var EntityManager
     */
    protected $em;


    /**
     * GalleryController constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Lists all galleries
     */
    public function listAction()
    {
        $galleriesRepository = $this->em->getRepository('OurPhotos:Gallery');
        $galleries = $galleriesRepository->findAll();

        return new JsonResponse(['galleries' => $galleries]);
    }


    public function createAction()
    {
        $gallery = new Gallery();

        $this->em->persist($gallery);
        $this->em->flush($gallery);

        throw new \OutOfBoundsException('Endpoint not defined yet');
    }


    public function updateAction()
    {
        throw new \OutOfBoundsException('Endpoint not defined yet');
    }


    public function deleteAction()
    {
        throw new \OutOfBoundsException('Endpoint not defined yet');
    }
}