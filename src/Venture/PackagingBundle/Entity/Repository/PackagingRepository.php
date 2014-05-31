<?php

namespace Venture\PackagingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VendorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PackagingRepository extends EntityRepository {
    
    public function getLatestPackaging($active = false, $limit = NULL) {
         $qb = $this->createQueryBuilder('p')
                    ->select('p')
                    ->addOrderBy('p.updated', 'DESC');
        
        if (true === $active)
            $qb->andWhere('p.is_active = :active')
               ->setParameter('active', $active);


        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}