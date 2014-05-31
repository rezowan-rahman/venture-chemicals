<?php

namespace Venture\IntermediateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * FinishedProduct
 *
 * @ORM\Table(name="ven_intermediates")
 * @ORM\Entity(repositoryClass="Venture\IntermediateBundle\Entity\Repository\IntermediateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Intermediate
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
     * @ORM\Column(name="tags", type="string", length=200)
     */
    private $tags;
    
    /**
     * @var string
     * @ORM\Column(name="reason_for_change", type="text")
     */
    private $reasonForChange;

    
    
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
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\UnitOfMeasure", inversedBy="intermediates")
     * @ORM\JoinColumn(name="unit_of_measure_id", referencedColumnName="id")
     */
    protected $unitOfMeasure;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Formula", mappedBy="ingredient", cascade={"all"})
     */
    protected $commonFormulas;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Property", mappedBy="intermediate", cascade={"persist"})
     */
    protected $properties;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Formula", mappedBy="intermediate", cascade={"all"})
     */
    protected $formulas;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\DataChangeLog", mappedBy="intermediate", cascade={"all"})
     */
    protected $changeLogs;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Tag", mappedBy="intermediates")
     */
    protected $testTags;


    public function __construct() {
        $this->testTags     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->properties   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formulas     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->changeLogs   = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set tags
     *
     * @param string $tags
     * @return FinishedProduct
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    public function setReasonForChange($reasonForChange) {
        $this->reasonForChange = $reasonForChange;
        return $this;
    }
    
    public function getReasonForChange() {
        return $this->reasonForChange;
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
    
    public function setUnitOfMeasure(\Settings\ConfigBundle\Entity\UnitOfMeasure $unitOfMeasure = null) {
        $this->unitOfMeasure = $unitOfMeasure;
        return $this;
    }
    
    public function getUnitOfMeasure() {
        return $this->unitOfMeasure;
    }
    
    public function addCommonFormula(\Venture\CommonBundle\Entity\Formula $commonFormula) {
        $this->commonFormulas[] = $commonFormula;
        return $this;
    }

    public function removeCommonFormula(\Venture\CommonBundle\Entity\Formula $commonFormula) {
        $this->commonFormulas->removeElement($commonFormula);
    }

    public function getCommonFormulas() {
        return $this->commonFormulas;
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
    
    public function addTestTag(\Venture\CommonBundle\Entity\Tag $testTag) {
        $this->testTags[] = $testTag;
        return $this;
    }

    public function removeTestTag(\Venture\CommonBundle\Entity\Tag $testTag) {
        $this->testTags->removeElement($testTag);
    }

    public function getTestTags() {
        return $this->testTags;
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
}