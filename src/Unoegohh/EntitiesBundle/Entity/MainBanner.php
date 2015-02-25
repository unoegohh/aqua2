<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="banner")
 */
class MainBanner
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(type="string")
     */
    protected $descr;

    /**
     * @ORM\Column(type="boolean" , nullable=true)
     */
    protected $showDesc;

    /**
     * @ORM\Column(type="string")
     */
    protected $image_url;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @ORM\Column(type="integer")
     */
    protected $orderNum;

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
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
     * @param mixed $image_url
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
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
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
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

    /**
     * @param mixed $orderNum
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;
    }

    /**
     * @return mixed
     */
    public function getOrderNum()
    {
        return $this->orderNum;
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
     * @param mixed $showDesc
     */
    public function setShowDesc($showDesc)
    {
        $this->showDesc = $showDesc;
    }

    /**
     * @return mixed
     */
    public function getShowDesc()
    {
        return $this->showDesc;
    }



}