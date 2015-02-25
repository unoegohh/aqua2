<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact_pref")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $descr;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mapX;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mapY;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $workHours;

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
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
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
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
     * @param mixed $mapX
     */
    public function setMapX($mapX)
    {
        $this->mapX = $mapX;
    }

    /**
     * @return mixed
     */
    public function getMapX()
    {
        return $this->mapX;
    }

    /**
     * @param mixed $mapY
     */
    public function setMapY($mapY)
    {
        $this->mapY = $mapY;
    }

    /**
     * @return mixed
     */
    public function getMapY()
    {
        return $this->mapY;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $workHours
     */
    public function setWorkHours($workHours)
    {
        $this->workHours = $workHours;
    }

    /**
     * @return mixed
     */
    public function getWorkHours()
    {
        return $this->workHours;
    }


}