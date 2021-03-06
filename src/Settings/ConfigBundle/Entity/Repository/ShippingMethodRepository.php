<?php

namespace Settings\ConfigBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ShippingMethodRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShippingMethodRepository extends EntityRepository {
    public function getLatestMethods($limit = NULL) {
        $qb = $this->createQueryBuilder('sm')
                    ->select('sm')
                    ->addOrderBy('sm.updated', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                ->getResult();
    }
}
