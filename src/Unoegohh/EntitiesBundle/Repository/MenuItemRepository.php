<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\UserBundle\Entity\User;

class MenuItemRepository extends EntityRepository
{
    public function getMainMenu(User $user = null)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->isNull('u.parent'))
            ->leftJoin('u.child', 'c')
            ->orderBy("u.orderNum", "ASC");

        if(!$user){
            $qb->andWhere($qb->expr()->neq('u.show_to_user', 1));
        }
        return $qb->getQuery()->getResult();
    }

}