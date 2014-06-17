<?php

namespace Venture\FinishedProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

use Venture\CommonBundle\Entity\SalesPointCost;

/**
 * FinishedProduct
 *
 * @ORM\Table(name="ven_finished_products")
 * @ORM\Entity(repositoryClass="Venture\FinishedProductBundle\Entity\Repository\FinishedProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class FinishedProduct
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
     * @ORM\Column(name="item_number", type="string", length=50)
     */
    private $itemNumber;

    /**
     * @var string
     * @ORM\Column(name="item_name", type="string", length=50)
     */
    private $itemName;

    /**
     * @var string
     * @ORM\Column(name="item_description", type="string", length=200)
     */
    private $itemDescription;

    /**
     * @var string
     * @ORM\Column(name="reason_for_change", type="text")
     */
    private $reasonForChange;

    /**
     * @var string
     * @ORM\Column(name="reorder_point", type="string", length=10)
     */
    private $reorderPoint;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $quotingCost;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $lowestCost;

    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $standard_cost;

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
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\Packaging", inversedBy="finishedProducts")
     * @ORM\JoinColumn(name="packaging_id", referencedColumnName="id")
     */
    protected $configPackaging;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Property", mappedBy="finishedProduct", cascade={"persist"})
     */
    protected $properties;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Formula", mappedBy="finishedProduct", cascade={"all"})
     */
    protected $formulas;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\DataChangeLog", mappedBy="finishedProduct", cascade={"all"})
     */
    protected $changeLogs;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Tag", mappedBy="finishedProducts", cascade={"all"})
     */
    protected $tags;
    
    /**
     * @ORM\OneToMany(targetEntity="Venture\CommonBundle\Entity\SalesPointCost", mappedBy="finishedProduct", cascade={"all"})
     */
    protected $salesPointCosts;
    
    /**
     * @ORM\ManyToMany(targetEntity="Venture\CompetitiveProductBundle\Entity\CompetitiveProduct", mappedBy="finishedProducts")
     */
    protected $competitiveProducts;


    public function __construct() {
        $this->tags                 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->properties           = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formulas             = new \Doctrine\Common\Collections\ArrayCollection();
        $this->changeLogs           = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salesPointCosts      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competitiveProducts  = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set itemNumber
     *
     * @param string $itemNumber
     * @return FinishedProduct
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
    
        return $this;
    }

    /**
     * Get itemNumber
     *
     * @return string 
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     * @return FinishedProduct
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    
        return $this;
    }

    /**
     * Get itemName
     *
     * @return string 
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set itemDescription
     *
     * @param string $itemDescription
     * @return FinishedProduct
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    
        return $this;
    }

    /**
     * Get itemDescription
     *
     * @return string 
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    public function setReasonForChange($reasonForChange) {
        $this->reasonForChange = $reasonForChange;
        return $this;
    }
    
    public function getReasonForChange() {
        return $this->reasonForChange;
    }

    /**
     * Set reorderPoint
     *
     * @param string $reorderPoint
     * @return FinishedProduct
     */
    public function setReorderPoint($reorderPoint)
    {
        $this->reorderPoint = $reorderPoint;
    
        return $this;
    }

    /**
     * Get reorderPoint
     *
     * @return string 
     */
    public function getReorderPoint()
    {
        return $this->reorderPoint;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return FinishedProduct
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
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
    
    public function setConfigPackaging(\Settings\ConfigBundle\Entity\Packaging $configPackaging = null) {
        $this->configPackaging = $configPackaging;
        return $this;
    }
    
    public function getConfigPackaging() {
        return $this->configPackaging;
    }
    
    public function addProperty(\Venture\CommonBundle\Entity\Property $property) {
        $this->properties[] = $property;
        return $this;
    }

    public function removeProperty(\Venture\CommonBundle\Entity\Property $property) {
        $this->properties->removeElement($property);
    }

    public function getProperties() {
        return $this->properties;
    }
    
    public function addFormula(\Venture\CommonBundle\Entity\Formula $formula) {
        $this->formulas[] = $formula;
        return $this;
    }

    public function removeFormula(\Venture\CommonBundle\Entity\Formula $formula) {
        $this->formulas->removeElement($formula);
    }

    public function getFormulas() {
        return $this->formulas;
    }
    
    public function addTag(\Venture\CommonBundle\Entity\Tag $tag) {
        $this->tags[] = $tag;
        return $this;
    }

    public function removeTag(\Venture\CommonBundle\Entity\Tag $tag) {
        $this->tags->removeElement($tag);
    }

    public function getTags() {
        return $this->tags;
    }
    
    public function addChangeLog(\Venture\CommonBundle\Entity\DataChangeLog $changeLog) {
        $this->changeLogs[] = $changeLog;
        return $this;
    }

    public function removeChangeLog(\Venture\CommonBundle\Entity\DataChangeLog $changeLog) {
        $this->changeLogs->removeElement($changeLog);
    }

    public function getChangeLogs() {
        return $this->changeLogs;
    }
    
    public function setQuotingCost($quotingCost) {
        $this->quotingCost = $quotingCost;
        return $this;
    }

    
    public function getQuotingCost() {
        return $this->quotingCost;
    }
    
    public function setLowestCost($lowestCost) {
        $this->lowestCost = ($lowestCost == 99999) ? 0 : $lowestCost;
        return $this;
    }

    
    public function getLowestCost() {
        return $this->lowestCost;
    }
    
    public function setStandardCost($standardCost) {
        $this->standard_cost = $standardCost;
        return $this;
    }

    
    public function getStandardCost() {
        return $this->standard_cost;
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

    /**
     * Add competitiveProducts
     *
     * @param \Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $competitiveProducts
     * @return FinishedProduct
     */
    public function addCompetitiveProduct(\Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $competitiveProducts)
    {
        $this->competitiveProducts[] = $competitiveProducts;
    
        return $this;
    }

    /**
     * Remove competitiveProducts
     *
     * @param \Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $competitiveProducts
     */
    public function removeCompetitiveProduct(\Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $competitiveProducts)
    {
        $this->competitiveProducts->removeElement($competitiveProducts);
    }

    /**
     * Get competitiveProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompetitiveProducts()
    {
        return $this->competitiveProducts;
    }
}