<?php

namespace Venture\IntermediateBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VendorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IntermediateRepository extends EntityRepository {
    
    public function getLatestIntermediates($active = false, $limit = NULL) {
         $qb = $this->createQueryBuilder('i')
                    ->select('i')
                    ->addOrderBy('i.updated', 'DESC');
        
        if (true === $active)
            $qb->andWhere('i.isActive = :active')
               ->setParameter('active', $active);


        return $qb->getQuery();
    }
    
    public function getTotalPercentage($id, $active = true) {
         $query = $this->createQueryBuilder('i')
                ->select("SUM(f.amount) as total_amount")
                ->leftJoin("i.formulas", "f")
                ->where('i.id = :id')->setParameter('id', $id)
                ->andWhere('i.isActive = :active')->setParameter('active', $active)
                ->groupBy("f.intermediate")
                ->getQuery()
                ->getArrayResult();
        
        return array_shift($query);
    }
    
    public function getCost($id, $type="MAX", $active = true) {
         /*select sum(total) as total_cost from (
select max(s.cost_per_unit)*f.amount as total
from ven_intermediates as i
left join ven_common_formulas as f on f.intermediate_id = i.id
left join ven_shipping_details as s on s.raw_material_id = f.raw_material_id
where i.id = 5 and i.is_active = true
group by f.amount, f.raw_material_id
) t1*/
       $query1 = $this->createQueryBuilder("i")
                ->select("{$type}(s.cost_per_unit) * (f.amount/100) as total")
                ->join("i.formulas", "f")->join("f.rawMaterial", "m")->join("m.shipping_details", "s")
                ->where("i.id = :id")->setParameter("id", $id)
                ->andWhere("i.isActive = :active")->setParameter("active", $active)
                ->groupBy("f.amount, f.rawMaterial")
                ->getQuery();
       
       $val = 0;
       foreach($query1->getArrayResult() as $row) {
           $val = $val + $row["total"];
       }
       
       return $val;         
    }
    
}