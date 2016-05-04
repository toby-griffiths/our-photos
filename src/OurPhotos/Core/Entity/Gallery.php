<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 04/05/2016
 * Time: 12:44
 */

namespace OurPhotos\Core\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Gallery
 *
 * @package OurPhotos\OurPhotos\Core
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class Gallery
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
}