<?php

namespace Venture\AlternateRawMaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * AlternateRawMaterial
 *
 * @ORM\Table(name="ven_alternate_raw_materials")
 * @ORM\Entity(repositoryClass="Venture\AlternateRawMaterialBundle\Entity\Repository\AlternateRawMaterialRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AlternateRawMaterial
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
     * @ORM\Column(name="item_name", type="string", length=100)
     * @Assert\NotBlank
     */
    private $itemName;

    /**
     * @var string
     *
     * @ORM\Column(name="item_description", type="text")
     * @Assert\NotBlank
     */
    private $itemDescription;

    /**
     * @var float
     *
     * @ORM\Column(name="quoting_cost", type="decimal", precision=10, scale=2)
     */
    private $quotingCost;

    /**
     * @var float
     *
     * @ORM\Column(name="lowest_cost", type="decimal", precision=10, scale=2)
     */
    private $lowestCost;

    /**
     * @var boolean
     *
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
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\UnitOfMeasure", inversedBy="alternateRawMaterials")
     * @ORM\JoinColumn(name="unit_of_measure_id", referencedColumnName="id")
     * @Assert\NotBlank
     */
    protected $unitOfMeasure;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Property", mappedBy="alternateRawMaterials", cascade={"all"})
     */
    protected $properties;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\ShippingDetails", mappedBy="alternateRawMaterial", cascade={"all"})
     */
    protected $orderingDetails;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\RawMaterialsBundle\Entity\RawMaterials", inversedBy="alternateRawMaterials")
     * @ORM\JoinTable(
     *      name="ven_raw_materials_alternate_raw_materials",
     *      joinColumns={@ORM\JoinColumn(name="raw_material_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="alternate_raw_material_id", referencedColumnName="id")}
     * )
     */

    protected $rawMaterials;

    /**
     * @ORM\Column(name="is_converted_to_raw_material", type="boolean")
     */
    protected $isConvertedToRawMaterial;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Tag", mappedBy="alternateRawMaterials", cascade={"all"})
     */
    protected $tags;


    /**
     * Constructor
     */
    public function __construct() {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderingDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rawMaterials = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set itemName
     *
     * @param string $itemName
     * @return AlternateRawMaterial
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
     * @return AlternateRawMaterial
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
     * Set quotingCost
     *
     * @param float $quotingCost
     * @return AlternateRawMaterial
     */
    public function setQuotingCost($quotingCost)
    {
        $this->quotingCost = $quotingCost;
    
        return $this;
    }

    /**
     * Get quotingCost
     *
     * @return float 
     */
    public function getQuotingCost()
    {
        return $this->quotingCost;
    }

    /**
     * Set lowestCost
     *
     * @param float $lowestCost
     * @return AlternateRawMaterial
     */
    public function setLowestCost($lowestCost)
    {
        $this->lowestCost = ($lowestCost == 99999)? 0 :$lowestCost;
    
        return $this;
    }

    /**
     * Get lowestCost
     *
     * @return float 
     */
    public function getLowestCost()
    {
        return $this->lowestCost;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return AlternateRawMaterial
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
    
    
    /**
     * Set unitOfMeasure
     *
     * @param \Settings\ConfigBundle\Entity\UnitOfMeasure $unitOfMeasure
     * @return AlternateRawMaterial
     */
    public function setUnitOfMeasure(\Settings\ConfigBundle\Entity\UnitOfMeasure $unitOfMeasure = null)
    {
        $this->unitOfMeasure = $unitOfMeasure;
    
        return $this;
    }

    /**
     * Get unitOfMeasure
     *
     * @return \Settings\ConfigBundle\Entity\UnitOfMeasure 
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

    /**
     * Add properties
     *
     * @param \Venture\CommonBundle\Entity\Property $properties
     * @return AlternateRawMaterial
     */
    public function addProperty(\Venture\CommonBundle\Entity\Property $properties)
    {
        $this->properties[] = $properties;
    
        return $this;
    }

    /**
     * Remove properties
     *
     * @param \Venture\CommonBundle\Entity\Property $properties
     */
    public function removeProperty(\Venture\CommonBundle\Entity\Property $properties)
    {
        $this->properties->removeElement($properties);
    }

    /**
     * Get properties
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Add orderingDetails
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $orderingDetails
     * @return AlternateRawMaterial
     */
    public function addOrderingDetail(\Venture\CommonBundle\Entity\ShippingDetails $orderingDetails)
    {
        $this->orderingDetails[] = $orderingDetails;
    
        return $this;
    }

    /**
     * Remove orderingDetails
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $orderingDetails
     */
    public function removeOrderingDetail(\Venture\CommonBundle\Entity\ShippingDetails $orderingDetails)
    {
        $this->orderingDetails->removeElement($orderingDetails);
    }

    /**
     * Get orderingDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderingDetails()
    {
        return $this->orderingDetails;
    }

    /**
     * Add rawMaterials
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials
     * @return AlternateRawMaterial
     */
    public function addRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->rawMaterials[] = $rawMaterials;
    
        return $this;
    }

    /**
     * Remove rawMaterials
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials
     */
    public function removeRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->rawMaterials->removeElement($rawMaterials);
    }

    /**
     * Get rawMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterials()
    {
        return $this->rawMaterials;
    }

    /**
     * Set isConvertedToRawMaterial
     *
     * @param boolean $isConvertedToRawMaterial
     * @return AlternateRawMaterial
     */
    public function setIsConvertedToRawMaterial($isConvertedToRawMaterial)
    {
        $this->isConvertedToRawMaterial = $isConvertedToRawMaterial;
    
        return $this;
    }

    /**
     * Get isConvertedToRawMaterial
     *
     * @return boolean 
     */
    public function getIsConvertedToRawMaterial()
    {
        return $this->isConvertedToRawMaterial;
    }

    /**
     * Add tags
     *
     * @param \Venture\CommonBundle\Entity\Tag $tags
     * @return AlternateRawMaterial
     */
    public function addTag(\Venture\CommonBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Venture\CommonBundle\Entity\Tag $tags
     */
    public function removeTag(\Venture\CommonBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
