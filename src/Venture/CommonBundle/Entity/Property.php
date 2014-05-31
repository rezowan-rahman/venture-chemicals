<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Property
 *
 * @ORM\Table(name="ven_common_properties")
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\PropertyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Property
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
     * @ORM\Column(name="specification", type="string", length=50, nullable=true)
     */
    private $specification;

    /**
     * @var string
     * @ORM\Column(name="specification_math", type="string", length=50, nullable=true)
     */
    private $specificationMath;

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
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\Property", inversedBy="commonProperties")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\TestProcedure", inversedBy="commonProperties")
     * @ORM\JoinColumn(name="test_procedure_id", referencedColumnName="id")
     */
    protected $testProcedure;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="properties")
     * @ORM\JoinColumn(name="finished_Product_id", referencedColumnName="id")
     */
    protected $finishedProduct;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\RawMaterialsBundle\Entity\RawMaterials", inversedBy="specs")
     * @ORM\JoinColumn(name="raw_material_id", referencedColumnName="id")
     */
    protected $raw_material;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\IntermediateBundle\Entity\Intermediate", inversedBy="properties")
     * @ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")
     */
    protected $intermediate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\CompetitiveProductBundle\Entity\CompetitiveProduct", inversedBy="properties")
     * @ORM\JoinColumn(name="competitive_product_id", referencedColumnName="id")
     */
    protected $competitiveProduct;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial", inversedBy="properties")
     * @ORM\JoinColumn(name="alternate_raw_material_id", referencedColumnName="id")
     */
    protected $alternateRawMaterial;
    

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
     * Set specification
     *
     * @param string $specification
     * @return Property
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;
    
        return $this;
    }

    /**
     * Get specification
     *
     * @return string 
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * Set specificationMath
     *
     * @param string $specificationMath
     * @return Property
     */
    public function setSpecificationMath($specificationMath)
    {
        $this->specificationMath = $specificationMath;
    
        return $this;
    }

    /**
     * Get specificationMath
     *
     * @return string 
     */
    public function getSpecificationMath()
    {
        return $this->specificationMath;
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
    
    public function setProperty(\Settings\ConfigBundle\Entity\Property $property = null) {
        $this->property = $property;
        return $this;
    }
    
    public function getProperty() {
        return $this->property;
    }
    
    public function setTestProcedure(\Settings\ConfigBundle\Entity\TestProcedure $testProcedure = null) {
        $this->testProcedure = $testProcedure;
        return $this;
    }
    
    public function getTestProcedure() {
        return $this->testProcedure;
    }
    
    public function setFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct = null) {
        $this->finishedProduct = $finishedProduct;
        return $this;
    }
    
    public function getFinishedProduct() {
        return $this->finishedProduct;
    }
    
    public function setRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterial = null) {
        $this->raw_material = $rawMaterial;
        return $this;
    }

    public function getRawMaterial() {
        return $this->raw_material;
    }
    
    public function setIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediate = null) {
        $this->intermediate = $intermediate;
        return $this;
    }
    
    public function getIntermediate() {
        return $this->intermediate;
    }
    
    public function setCompetitiveProduct(\Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $obj = null) {
        $this->competitiveProduct = $obj;
        return $this;
    }
    
    public function getCompetitiveProduct() {
        return $this->competitiveProduct;
    }

    /**
     * Set alternateRawMaterial
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterial
     * @return Property
     */
    public function setAlternateRawMaterial(\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterial = null)
    {
        $this->alternateRawMaterial = $alternateRawMaterial;
    
        return $this;
    }

    /**
     * Get alternateRawMaterial
     *
     * @return \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial 
     */
    public function getAlternateRawMaterial()
    {
        return $this->alternateRawMaterial;
    }
}