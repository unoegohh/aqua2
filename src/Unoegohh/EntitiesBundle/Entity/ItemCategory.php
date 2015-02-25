<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Unoegohh\EntitiesBundle\Repository\ItemCategoryRepository")
 * @ORM\Table(name="item_category")
 */
class ItemCategory
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
     * @ORM\Column(type="string",nullable=true)
     */
    protected $engName;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descr;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $orderNum;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemCategory", inversedBy="child")
     * @ORM\JoinColumn(name="child_id", referencedColumnName="id")
     **/
    protected $child_id;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemCategory", mappedBy="child_id", cascade={"remove", "persist"})
     * @ORM\OrderBy({"orderNum" = "ASC"})
     **/
    protected $child;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\Item", mappedBy="category_id", cascade={"remove", "persist"})
     **/
    protected $items;

    function __construct()
    {
        $this->child = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    function __toString()
    {
        return $this->getName();
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
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
     * @param mixed $child_id
     */
    public function setChildId($child_id)
    {
        $this->child_id = $child_id;
    }

    /**
     * @return mixed
     */
    public function getChildId()
    {
        return $this->child_id;
    }

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
     * @param mixed $engName
     */
    public function setEngName($engName)
    {
        $this->engName = $engName;
    }

    /**
     * @return mixed
     */
    public function getEngName()
    {
        return $this->engName;
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


}