<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Formula
 *
 * @ORM\Table(name="ven_common_formulas")
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\FormulaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Formula
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
     * @ORM\Column(name="amount", type="string", length=20)
     */
    private $amount;

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
     * @ORM\ManyToOne(targetEntity="Venture\RawMaterialsBundle\Entity\RawMaterials", inversedBy="commonFormulas")
     * @ORM\JoinColumn(name="raw_material_id", referencedColumnName="id")
     */
    protected $rawMaterial;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\IntermediateBundle\Entity\Intermediate", inversedBy="commonFormulas")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     */
    protected $ingredient;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="formulas")
     * @ORM\JoinColumn(name="finished_Product_id", referencedColumnName="id")
     */
    protected $finishedProduct;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\IntermediateBundle\Entity\Intermediate", inversedBy="formulas")
     * @ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")
     */
    protected $intermediate;


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
     * Set amount
     *
     * @param string $amount
     * @return Formula
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
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
    
    public function setRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterial = null) {
        $this->rawMaterial = $rawMaterial;
        return $this;
    }
    
    public function getRawMaterial() {
        return $this->rawMaterial;
    }
    
    public function setIngredient(\Venture\IntermediateBundle\Entity\Intermediate $ingredient = null) {
        $this->ingredient = $ingredient;
        return $this;
    }
    
    public function getIngredient() {
        return $this->ingredient;
    }
    
    public function setFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct = null) {
        $this->finishedProduct = $finishedProduct;
        return $this;
    }
    
    public function getFinishedProduct() {
        return $this->finishedProduct;
    }
    
    public function setIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediate = null) {
        $this->intermediate = $intermediate;
        return $this;
    }
    
    public function getIntermediate() {
        return $this->intermediate;
    }
}
