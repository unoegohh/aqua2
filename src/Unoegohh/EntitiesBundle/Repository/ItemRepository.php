<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\UserBundle\Entity\User;

class ItemRepository extends EntityRepository
{
    public function getProductsByCategory(ItemCategory $category = null)
    {
        $qb = $this->createQueryBuilder('u');
        if($category){

            $ids = array();
            $ids[] = $category->getId();
            foreach($category->getChild() as $child){
                $ids[] = $child->getId();
            }
            $qb
                ->where($qb->expr()->in('u.category_id', $ids));
        }

        return $qb->getQuery()->getResult();
    }

    public function getNamedProducts($name)
    {

        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->like('u.name', $qb->expr()->literal('%' . $name . '%')))
            ->orWhere($qb->expr()->like('u.article', $qb->expr()->literal('%' . $name . '%')));

        return $qb->getQuery()->getResult();
    }

}