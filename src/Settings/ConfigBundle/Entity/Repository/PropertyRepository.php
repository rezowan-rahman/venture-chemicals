<?php

namespace Settings\ConfigBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PropertyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PropertyRepository extends EntityRepository {
    public function getLatestProperties($limit = NULL) {
        $qb = $this->createQueryBuilder('p')
                    ->select('p')
                    ->addOrderBy('p.updated', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                ->getResult();
    }
}
