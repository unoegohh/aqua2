<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_pref")
 */
class SitePref
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
    protected $priceEUR;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $priceUSD;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", nullable=true, length=1024)
     */
    protected $contactsText;

    /**
     * @param mixed $priceEUR
     */
    public function setPriceEUR($priceEUR)
    {
        $this->priceEUR = $priceEUR;
    }

    /**
     * @return mixed
     */
    public function getPriceEUR()
    {
        return $this->priceEUR;
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
     * @param mixed $priceUSD
     */
    public function setPriceUSD($priceUSD)
    {
        $this->priceUSD = $priceUSD;
    }

    /**
     * @return mixed
     */
    public function getPriceUSD()
    {
        return $this->priceUSD;
    }

    /**
     * @param mixed $contactsText
     */
    public function setContactsText($contactsText)
    {
        $this->contactsText = $contactsText;
    }

    /**
     * @return mixed
     */
    public function getContactsText()
    {
        return $this->contactsText;
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
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logoSize
     */
    public function setLogoSize($logoSize)
    {
        $this->logoSize = $logoSize;
    }

    /**
     * @return mixed
     */
    public function getLogoSize()
    {
        return $this->logoSize;
    }



}