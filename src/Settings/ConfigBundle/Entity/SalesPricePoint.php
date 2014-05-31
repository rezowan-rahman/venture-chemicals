<?php

namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

use Venture\CommonBundle\Entity\SalesPointCost;

/**
 * SalesPricePoint
 *
 * @ORM\Table(name="ven_sales_price_point")
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\SalesPricePointRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SalesPricePoint
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
     * @var string
     *
     * @ORM\Column(name="salesCostPoint", type="string", length=50)
     */
    private $salesCostPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $approved;

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
     * @ORM\OneToMany(targetEntity="Venture\CommonBundle\Entity\SalesPointCost", mappedBy="salesPricePoint", cascade={"all"})
     */
    protected $salesPointCosts;


    public function __construct() {
        $this->salesPointCosts      = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set salesCostPoint
     *
     * @param string $salesCostPoint
     * @return SalesPricePoint
     */
    public function setSalesCostPoint($salesCostPoint)
    {
        $this->salesCostPoint = $salesCostPoint;
    
        return $this;
    }

    /**
     * Get salesCostPoint
     *
     * @return string 
     */
    public function getSalesCostPoint()
    {
        return $this->salesCostPoint;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return SalesPricePoint
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
    
    public function setApproved($approved) {
        $this->approved = $approved;
        return $this;
    }

    public function getApproved() {
        return $this->approved;
    }
    
    public function addSalesPointCost(SalesPointCost $obj) {
        $this->salesPointCosts[] = $obj;
        return $this;
    }

    public function removeSalesPointCost(SalesPointCost $obj) {
        $this->salesPointCosts->removeElement($obj);
    }

    public function getSalesPointCosts() {
        return $this->salesPointCosts;
    }
}
