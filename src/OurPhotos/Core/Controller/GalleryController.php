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
use OurPhotos\Core\Formatter\Formatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @var Formatter
     */
    private $formatter;


    /**
     * GalleryController constructor.
     *
     * @param EntityManager $em
     * @param Formatter     $formatter
     */
    public function __construct(EntityManager $em, Formatter $formatter)
    {
        $this->em        = $em;
        $this->formatter = $formatter;
    }


    /**
     * Lists all galleries
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        $galleriesRepository = $this->em->getRepository('OurPhotos:Gallery');
        $galleries           = $galleriesRepository->findAll();

        $galleriesResponse = array_map([$this->formatter, 'format'], $galleries);

        return new JsonResponse(['galleries' => $galleriesResponse]);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $data = $request->request->all();

        $gallery = new Gallery();
        $gallery->setTitle($data['title']);

        $this->em->persist($gallery);
        $this->em->flush($gallery);

        return new JsonResponse(['gallery' => ['id' => $gallery->getId()]], 201);
    }


    /**
     * @param Gallery $gallery
     *
     * @return JsonResponse
     */
    public function viewAction(Gallery $gallery)
    {
        $galleryResponse = $this->formatter->format($gallery);

        return new JsonResponse(['gallery' => $galleryResponse]);
    }


    public function updateAction()
    {
        throw new \OutOfBoundsException('Endpoint not defined yet');
    }


    /**
     * @param Gallery $gallery
     *
     * @return Response
     */
    public function deleteAction(Gallery $gallery)
    {
        $this->em->remove($gallery);
        $this->em->flush($gallery);

        return new Response('', 200);
    }
}