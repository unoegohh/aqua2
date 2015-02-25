<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="item_image")
 */
class ItemImage
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
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $descr;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\Item", inversedBy="photos")
     * @ORM\JoinColumn(name="food_item_id", referencedColumnName="id")
     **/
    protected $item_id;

    /**
     * @param mixed $desc
     */
    public function setDescr($desc)
    {
        $this->descr = $desc;
    }

    /**
     * @return mixed
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
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
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


}