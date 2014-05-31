<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

use Venture\FinishedProductBundle\Entity\FinishedProduct;
use Settings\ConfigBundle\Entity\SalesPricePoint;

/**
 * SalesPointCost
 *
 * @ORM\Table(name="ven_sales_point_cost")
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\SalesPointCostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SalesPointCost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="decimal")
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="salesPointCosts")
     * @ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")
     */
    private $finishedProduct;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\SalesPricePoint", inversedBy="salesPointCosts")
     * @ORM\JoinColumn(name="sales_price_point_id", referencedColumnName="id")
     */
    private $salesPricePoint;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return SalesPointCost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function setFinishedProduct(FinishedProduct $obj=null) {
        $this->finishedProduct = $obj;
        return $this;
    }
    
    public function getFinishedProduct() {
        return $this->finishedProduct;
    }
    
    public function setSalesPricePoint(SalesPricePoint $obj=null) {
        $this->salesPricePoint = $obj;
        return $this;
    }
    
    public function getSalesPricePoint() {
        return $this->salesPricePoint;
    }
}
