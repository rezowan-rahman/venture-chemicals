<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Venture\PackagingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Venture\PackagingBundle\Entity\Repository\PackagingRepository")
 * @ORM\Table(name="ven_packaging_details")
 * @ORM\HasLifecycleCallbacks
 */

class Packaging {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    protected $item_number;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    protected $item_name;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    protected $description;
    
    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $reorder_point;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $quotingCost;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $lowestCost;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_active;
    
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Settings\ConfigBundle\Entity\UnitOfMeasure", inversedBy="packaging")
     * @ORM\JoinColumn(name="unit_of_measure_id", referencedColumnName="id")
     * @Assert\NotBlank
     */
    protected $unit_of_measure;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\ShippingDetails", mappedBy="venturePackaging", cascade={"all"})
     */
    protected $shipping_details;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\CommonBundle\Entity\Tag", mappedBy="packagings", cascade={"all"})
     */
    protected $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shipping_details = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set item_number
     *
     * @param string $itemNumber
     * @return Packaging
     */
    public function setItemNumber($itemNumber)
    {
        $this->item_number = $itemNumber;
    
        return $this;
    }

    /**
     * Get item_number
     *
     * @return string 
     */
    public function getItemNumber()
    {
        return $this->item_number;
    }

    /**
     * Set item_name
     *
     * @param string $itemName
     * @return Packaging
     */
    public function setItemName($itemName)
    {
        $this->item_name = $itemName;
    
        return $this;
    }

    /**
     * Get item_name
     *
     * @return string 
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Packaging
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
     * Set reorder_point
     *
     * @param integer $reorderPoint
     * @return Packaging
     */
    public function setReorderPoint($reorderPoint)
    {
        $this->reorder_point = $reorderPoint;
    
        return $this;
    }

    /**
     * Get reorder_point
     *
     * @return integer 
     */
    public function getReorderPoint()
    {
        return $this->reorder_point;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return Packaging
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    
        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
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
     * Set unit_of_measure
     *
     * @param \Settings\ConfigBundle\Entity\UnitOfMeasure $unitOfMeasure
     * @return Packaging
     */
    public function setUnitOfMeasure(\Settings\ConfigBundle\Entity\UnitOfMeasure $unitOfMeasure = null)
    {
        $this->unit_of_measure = $unitOfMeasure;
    
        return $this;
    }

    /**
     * Get unit_of_measure
     *
     * @return \Settings\ConfigBundle\Entity\UnitOfMeasure 
     */
    public function getUnitOfMeasure()
    {
        return $this->unit_of_measure;
    }

    /**
     * Add shipping_details
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $shippingDetails
     * @return Packaging
     */
    public function addShippingDetail(\Venture\CommonBundle\Entity\ShippingDetails $shippingDetails)
    {
        $this->shipping_details[] = $shippingDetails;
    
        return $this;
    }

    /**
     * Remove shipping_details
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $shippingDetails
     */
    public function removeShippingDetail(\Venture\CommonBundle\Entity\ShippingDetails $shippingDetails)
    {
        $this->shipping_details->removeElement($shippingDetails);
    }

    /**
     * Get shipping_details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShippingDetails()
    {
        return $this->shipping_details;
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

    /**
     * Add testTags
     *
     * @param \Venture\CommonBundle\Entity\Tag $testTags
     * @return Packaging
     */
    public function addTag(\Venture\CommonBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove testTags
     *
     * @param \Venture\CommonBundle\Entity\Tag $testTags
     */
    public function removeTag(\Venture\CommonBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get testTags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
