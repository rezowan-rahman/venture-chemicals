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
     * @ORM\ManyToMany(targetEntity="\Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="properties", cascade={"all"})
     * @ORM\JoinTable(name="ven_finished_products_properties",
     *      joinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")}
     *      )
     **/
    protected $finishedProducts;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\RawMaterialsBundle\Entity\RawMaterials", inversedBy="specs", cascade={"all"})
     * @ORM\JoinTable(name="ven_raw_materials_properties",
     *      joinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="raw_material_id", referencedColumnName="id")}
     *      )
     **/
    protected $rawMaterials;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\IntermediateBundle\Entity\Intermediate", inversedBy="properties", cascade={"all"})
     * @ORM\JoinTable(name="ven_intermediates_properties",
     *      joinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")}
     *      )
     **/
    protected $intermediates;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CompetitiveProductBundle\Entity\CompetitiveProduct", inversedBy="properties", cascade={"all"})
     * @ORM\JoinTable(name="ven_competitive_products_properties",
     *      joinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competitive_product_id", referencedColumnName="id")}
     *      )
     **/
    protected $competitiveProducts;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial", inversedBy="properties", cascade={"all"})
     * @ORM\JoinTable(name="ven_alternate_raw_materials_properties",
     *      joinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="alternate_raw_material_id", referencedColumnName="id")}
     *      )
     **/
    protected $alternateRawMaterials;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finishedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rawMaterials = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intermediates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competitiveProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alternateRawMaterials = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Add rawMaterials
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials
     * @return Property
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
     * Add finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     * @return Property
     */
    public function addFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts)
    {
        $this->finishedProducts[] = $finishedProducts;

        return $this;
    }

    /**
     * Remove finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     */
    public function removeFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts)
    {
        $this->finishedProducts->removeElement($finishedProducts);
    }

    /**
     * Get finishedProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinishedProducts()
    {
        return $this->finishedProducts;
    }

    /**
     * Add intermediates
     *
     * @param \Venture\IntermediateBundle\Entity\Intermediate $intermediates
     * @return Property
     */
    public function addIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediates)
    {
        $this->intermediates[] = $intermediates;

        return $this;
    }

    /**
     * Remove intermediates
     *
     * @param \Venture\IntermediateBundle\Entity\Intermediate $intermediates
     */
    public function removeIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediates)
    {
        $this->intermediates->removeElement($intermediates);
    }

    /**
     * Get intermediates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntermediates()
    {
        return $this->intermediates;
    }

    /**
     * Add competitiveProducts
     *
     * @param \Venture\CompetitiveProductBundle\Entity\CompetitiveProduct $competitiveProducts
     * @return Property
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

    /**
     * Add alternateRawMaterials
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials
     * @return Property
     */
    public function addAlternateRawMaterial(\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials)
    {
        $this->alternateRawMaterials[] = $alternateRawMaterials;

        return $this;
    }

    /**
     * Remove alternateRawMaterials
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials
     */
    public function removeAlternateRawMaterial(\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials)
    {
        $this->alternateRawMaterials->removeElement($alternateRawMaterials);
    }

    /**
     * Get alternateRawMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlternateRawMaterials()
    {
        return $this->alternateRawMaterials;
    }
}
