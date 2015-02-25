<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\UserBundle\Entity\User;

class ItemCategoryRepository extends EntityRepository
{
    public function getCategoriesMenu()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->isNull('u.child_id'))
        ->orderBy('u.orderNum');
        return $qb->getQuery()->getResult();
    }
    public function getAllCategoriesWithProducts()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->leftJoin("u.items", "p")
            ->leftJoin("u.child_id", "c")
            ->leftJoin("c.items", "cp")
            ->where($qb->expr()->isNotNull('p.id'))
            ->orWhere($qb->expr()->isNotNull('cp.id'))
            ->orderBy('u.orderNum');
        return $qb->getQuery()->getResult();
    }

}