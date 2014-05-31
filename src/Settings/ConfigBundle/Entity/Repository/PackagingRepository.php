<?php

namespace Settings\ConfigBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TestProcedureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PackagingRepository extends EntityRepository {
    
    public function getLatestPackagings($limit = NULL) {
        $qb = $this->createQueryBuilder('pk')
                    ->select('pk')
                    ->addOrderBy('pk.updated', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                ->getResult();
    }
}