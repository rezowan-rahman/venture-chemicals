<?php

namespace Venture\PipeLineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PipeLine
 *
 * @ORM\Table(name="ven_pipelines")
 * @ORM\Entity(repositoryClass="Venture\PipeLineBundle\Entity\Repository\PipeLineRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PipeLine
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
     * @ORM\Column(name="probability", type="string", length=30)
     */
    private $probability;

    /**
     * @var string
     *
     * @ORM\Column(name="projected", type="string", length=30)
     */
    private $projected;

    /**
     * @var string
     *
     * @ORM\Column(name="expectedAnnualGrowth", type="string", length=30)
     */
    private $expectedAnnualGrowth;

    /**
     * @var string
     *
     * @ORM\Column(name="potential", type="string", length=30)
     */
    private $potential;

    /**
     * @var string
     *
     * @ORM\Column(name="goal", type="string", length=50)
     */
    private $goal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\PipeLineBundle\Entity\PipeLineYearSale", mappedBy="pipeLine", cascade={"all"})
     */
    protected $yearSales;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\PipeLineBundle\Entity\PipeLineNote", mappedBy="pipeLine", cascade={"all"})
     */
    protected $notes;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Venture\CustomerBundle\Entity\Customer", inversedBy="pipeLines")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\Pipelinetype", inversedBy="pipeLines")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\ProductLine", inversedBy="pipeLines")
     * @ORM\JoinColumn(name="product_line_id", referencedColumnName="id")
     */
    protected $productLine;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\Stage", inversedBy="pipeLines")
     * @ORM\JoinColumn(name="stage_id", referencedColumnName="id")
     */
    protected $stage;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\Salesrep", inversedBy="pipeLines")
     * @ORM\JoinColumn(name="sales_rep_id", referencedColumnName="id")
     */
    protected $salesRep;
    
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->yearSales = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set probability
     *
     * @param string $probability
     * @return PipeLine
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;
    
        return $this;
    }

    /**
     * Get probability
     *
     * @return string 
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * Set projected
     *
     * @param string $projected
     * @return PipeLine
     */
    public function setProjected($projected)
    {
        $this->projected = $projected;
    
        return $this;
    }

    /**
     * Get projected
     *
     * @return string 
     */
    public function getProjected()
    {
        return $this->projected;
    }

    /**
     * Set expectedAnnualGrowth
     *
     * @param string $expectedAnnualGrowth
     * @return PipeLine
     */
    public function setExpectedAnnualGrowth($expectedAnnualGrowth)
    {
        $this->expectedAnnualGrowth = $expectedAnnualGrowth;
    
        return $this;
    }

    /**
     * Get expectedAnnualGrowth
     *
     * @return string 
     */
    public function getExpectedAnnualGrowth()
    {
        return $this->expectedAnnualGrowth;
    }

    /**
     * Set potential
     *
     * @param string $potential
     * @return PipeLine
     */
    public function setPotential($potential)
    {
        $this->potential = $potential;
    
        return $this;
    }

    /**
     * Get potential
     *
     * @return string 
     */
    public function getPotential()
    {
        return $this->potential;
    }

    /**
     * Set goal
     *
     * @param string $goal
     * @return PipeLine
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    
        return $this;
    }

    /**
     * Get goal
     *
     * @return string 
     */
    public function getGoal()
    {
        return $this->goal;
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
    
    
    /**
     * Add yearSales
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLineYearSale $yearSales
     * @return PipeLine
     */
    public function addYearSale(\Venture\PipeLineBundle\Entity\PipeLineYearSale $yearSales)
    {
        $this->yearSales[] = $yearSales;
    
        return $this;
    }

    /**
     * Remove yearSales
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLineYearSale $yearSales
     */
    public function removeYearSale(\Venture\PipeLineBundle\Entity\PipeLineYearSale $yearSales)
    {
        $this->yearSales->removeElement($yearSales);
    }

    /**
     * Get yearSales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getYearSales()
    {
        return $this->yearSales;
    }

    /**
     * Add notes
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLineNote $notes
     * @return PipeLine
     */
    public function addNote(\Venture\PipeLineBundle\Entity\PipeLineNote $notes)
    {
        $this->notes[] = $notes;
    
        return $this;
    }

    /**
     * Remove notes
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLineNote $notes
     */
    public function removeNote(\Venture\PipeLineBundle\Entity\PipeLineNote $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set customer
     *
     * @param \Venture\CustomerBundle\Entity\Customer $customer
     * @return PipeLine
     */
    public function setCustomer(\Venture\CustomerBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return \Venture\CustomerBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set type
     *
     * @param \Settings\ConfigBundle\Entity\Pipelinetype $type
     * @return PipeLine
     */
    public function setType(\Settings\ConfigBundle\Entity\Pipelinetype $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Settings\ConfigBundle\Entity\Pipelinetype 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set productLine
     *
     * @param \Settings\ConfigBundle\Entity\ProductLine $productLine
     * @return PipeLine
     */
    public function setProductLine(\Settings\ConfigBundle\Entity\ProductLine $productLine = null)
    {
        $this->productLine = $productLine;
    
        return $this;
    }

    /**
     * Get productLine
     *
     * @return \Settings\ConfigBundle\Entity\ProductLine 
     */
    public function getProductLine()
    {
        return $this->productLine;
    }

    /**
     * Set stage
     *
     * @param \Settings\ConfigBundle\Entity\Stage $stage
     * @return PipeLine
     */
    public function setStage(\Settings\ConfigBundle\Entity\Stage $stage = null)
    {
        $this->stage = $stage;
    
        return $this;
    }

    /**
     * Get stage
     *
     * @return \Settings\ConfigBundle\Entity\Stage 
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set salesRep
     *
     * @param \Settings\ConfigBundle\Entity\Salesrep $salesRep
     * @return PipeLine
     */
    public function setSalesRep(\Settings\ConfigBundle\Entity\Salesrep $salesRep = null)
    {
        $this->salesRep = $salesRep;
    
        return $this;
    }

    /**
     * Get salesRep
     *
     * @return \Settings\ConfigBundle\Entity\Salesrep 
     */
    public function getSalesRep()
    {
        return $this->salesRep;
    }
}