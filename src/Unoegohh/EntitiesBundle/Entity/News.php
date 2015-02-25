<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 */
class News
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string",length=65535, nullable=true)
     */
    protected $descr;

    /**
     * @ORM\Column(type="string",length=65535)
     */
    protected $small_descr;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\NewsImage", mappedBy="item_id", cascade={"remove", "persist"})
     **/
    protected $photos;

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $descr
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    }

    /**
     * @return mixed
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $small_descr
     */
    public function setSmallDescr($small_descr)
    {
        $this->small_descr = $small_descr;
    }

    /**
     * @return mixed
     */
    public function getSmallDescr()
    {
        return $this->small_descr;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }


}