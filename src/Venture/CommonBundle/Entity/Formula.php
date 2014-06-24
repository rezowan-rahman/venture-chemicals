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
     * @ORM\ManyToMany(targetEntity="\Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="formulas", cascade={"all"})
     * @ORM\JoinTable(name="ven_finished_products_formulas",
     *      joinColumns={@ORM\JoinColumn(name="formula_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")}
     *      )
     **/
    protected $finishedProducts;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\IntermediateBundle\Entity\Intermediate", inversedBy="formulas", cascade={"all"})
     * @ORM\JoinTable(name="ven_intermediates_formulas",
     *      joinColumns={@ORM\JoinColumn(name="formula_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")}
     *      )
     **/
    protected $intermediates;


    public function __construct() {
        $this->finishedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intermediates = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Add finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     * @return Formula
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
     * @return Formula
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
}
