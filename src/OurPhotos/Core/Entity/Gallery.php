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

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     */
    protected $title;


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Gallery
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
