<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Unoegohh\EntitiesBundle\Repository\MenuItemRepository")
 * @ORM\Table(name="menu_items")
 */
class MenuItem
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
     * @ORM\Column(type="integer")
     */
    protected $orderNum;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $show_to_user;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\StaticPage")
     * @ORM\JoinColumn(name="static_page", referencedColumnName="id")
     **/
    protected $static_page;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\MenuItem", inversedBy="food_items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\MenuItem", mappedBy="parent", cascade={"remove", "persist"})
     **/
    protected $child;

    function __toString()
    {
        return $this->getName();
    }


    function __construct()
    {
        $this->child = new ArrayCollection();
    }

    /**
     * @param mixed $child
     */
    public function setChild($child)
    {
        $this->child = $child;
    }

    /**
     * @return mixed
     */
    public function getChild()
    {
        return $this->child;
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
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $static_page
     */
    public function setStaticPage($static_page)
    {
        $this->static_page = $static_page;
    }

    /**
     * @return mixed
     */
    public function getStaticPage()
    {
        return $this->static_page;
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
     * @param mixed $show
     */
    public function setShow($show)
    {
        $this->show = $show;
    }

    /**
     * @return mixed
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * @param mixed $show_to_user
     */
    public function setShowToUser($show_to_user)
    {
        $this->show_to_user = $show_to_user;
    }

    /**
     * @return mixed
     */
    public function getShowToUser()
    {
        return $this->show_to_user;
    }


}