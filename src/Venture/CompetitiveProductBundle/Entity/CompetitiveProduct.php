<?php

namespace Venture\CompetitiveProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\Common\Collections\ArrayCollection;
use Venture\CommonBundle\Entity\Property;
use Settings\ConfigBundle\Entity\Packaging;

/**
 * CompetitiveProduct
 *
 * @ORM\Table(name="ven_competitive_products")
 * @ORM\Entity(repositoryClass="Venture\CompetitiveProductBundle\Entity\Repository\CompetitiveProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CompetitiveProduct
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
     * @ORM\Column(name="item_name", type="string", length=255)
     */
    private $itemName;

    /**
     * @var string
     *
     * @ORM\Column(name="item_description", type="string", length=255)
     */
    private $itemDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="item_supplier", type="string", length=255)
     */
    private $itemSupplier;

    /**
     * @var float
     *
     * @ORM\Column(name="standard_cost", type="float")
     */
    private $standardCost;

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
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\Packaging", inversedBy="competitiveProducts")
     * @ORM\JoinColumn(name="packaging_id", referencedColumnName="id")
     */
    private $configPackaging;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Property", mappedBy="competitiveProducts", cascade={"persist"})
     */
    protected $properties;
    
    /**
     * @ORM\ManyToMany(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="competitiveProducts")
     * @ORM\JoinTable(
     *      name="ven_finished_products_competitive_products",
     *      joinColumns={@ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competitive_product_id", referencedColumnName="id")}
     * )
     */
    protected $finishedProducts;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Tag", mappedBy="competitiveProducts", cascade={"persist"})
     */
    protected $tags;
    
    
    public function __construct() {
        $this->properties       = new ArrayCollection();
        $this->finishedProducts = new ArrayCollection();
        $this->tags             = new ArrayCollection();
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
     * @return CompetitiveProduct
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
     * @return CompetitiveProduct
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
     * Set itemSupplier
     *
     * @param string $itemSupplier
     * @return CompetitiveProduct
     */
    public function setItemSupplier($itemSupplier)
    {
        $this->itemSupplier = $itemSupplier;
    
        return $this;
    }

    /**
     * Get itemSupplier
     *
     * @return string 
     */
    public function getItemSupplier()
    {
        return $this->itemSupplier;
    }

    /**
     * Set standardCost
     *
     * @param float $standardCost
     * @return CompetitiveProduct
     */
    public function setStandardCost($standardCost)
    {
        $this->standardCost = $standardCost;
    
        return $this;
    }

    /**
     * Get standardCost
     *
     * @return float 
     */
    public function getStandardCost()
    {
        return $this->standardCost;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return CompetitiveProduct
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
    
    public function setConfigPackaging(Packaging $obj = null) {
        $this->configPackaging = $obj;
        return $this;
    }
    
    public function getConfigPackaging() {
        return $this->configPackaging;
    }
    
    public function addProperty(Property $obj) {
        $this->properties[] = $obj;
        return $this;
    }

    public function removeProperty(Property $obj) {
        $this->properties->removeElement($obj);
    }

    public function getProperties() {
        return $this->properties;
    }
    
    /**
     * Add finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     * @return CompetitiveProduct
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
     * Add tags
     *
     * @param \Venture\CommonBundle\Entity\Tag $tags
     * @return CompetitiveProduct
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
