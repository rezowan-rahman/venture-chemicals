<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\ShippingDetailsRepository")
 * @ORM\Table(name="ven_shipping_details")
 * @ORM\HasLifecycleCallbacks
 */

class ShippingDetails {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\VendorBundle\Entity\Vendor", inversedBy="shipping_details")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected $vendor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\ShippingMethod", inversedBy="shipping_details")
     * @ORM\JoinColumn(name="shipping_method_id", referencedColumnName="id")
     */
    protected $shipping_method;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\ConfigBundle\Entity\Packaging", inversedBy="shipping_details")
     * @ORM\JoinColumn(name="config_packaging_id", referencedColumnName="id")
     */
    protected $configPackaging;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank
     */
    protected $amount_shipped;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lead_time;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank
     */
    protected $pre_freight_cost;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank
     */
    protected $freight_cost;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $total_cost;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $cost_per_unit;
    
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
     * @ORM\ManyToOne(targetEntity="Venture\RawMaterialsBundle\Entity\RawMaterials", inversedBy="shipping_details")
     * @ORM\JoinColumn(name="raw_material_id", referencedColumnName="id")
     */
    protected $raw_material;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\PackagingBundle\Entity\Packaging", inversedBy="shipping_details")
     * @ORM\JoinColumn(name="venture_packaging_id", referencedColumnName="id")
     */
    protected $venturePackaging;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial", inversedBy="orderingDetails")
     * @ORM\JoinColumn(name="alternate_raw_material_id", referencedColumnName="id")
     */
    protected $alternateRawMaterial;
    
    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setUpdatedCost()
    {
       $this->setTotalCost($this->getPreFreightCost() + $this->getFreightCost());
       $this->setCostPerUnit(($this->getAmountShipped())? $this->getTotalCost()/$this->getAmountShipped() : 0);
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
     * Set amount_shipped
     *
     * @param integer $amountShipped
     * @return ShippingDetails
     */
    public function setAmountShipped($amountShipped)
    {
        $this->amount_shipped = $amountShipped;
    
        return $this;
    }

    /**
     * Get amount_shipped
     *
     * @return integer 
     */
    public function getAmountShipped()
    {
        return $this->amount_shipped;
    }

    /**
     * Set lead_time
     *
     * @param integer $leadTime
     * @return ShippingDetails
     */
    public function setLeadTime($leadTime)
    {
        $this->lead_time = $leadTime;
    
        return $this;
    }

    /**
     * Get lead_time
     *
     * @return integer 
     */
    public function getLeadTime()
    {
        return $this->lead_time;
    }

    /**
     * Set pre_freight_cost
     *
     * @param integer $preFreightCost
     * @return ShippingDetails
     */
    public function setPreFreightCost($preFreightCost)
    {
        $this->pre_freight_cost = $preFreightCost;
    
        return $this;
    }

    /**
     * Get pre_freight_cost
     *
     * @return integer 
     */
    public function getPreFreightCost()
    {
        return $this->pre_freight_cost;
    }

    /**
     * Set freight_cost
     *
     * @param integer $freightCost
     * @return ShippingDetails
     */
    public function setFreightCost($freightCost)
    {
        $this->freight_cost = $freightCost;
    
        return $this;
    }

    /**
     * Get freight_cost
     *
     * @return integer 
     */
    public function getFreightCost()
    {
        return $this->freight_cost;
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
     * Set vendor
     *
     * @param \Venture\VendorBundle\Entity\Vendor $vendor
     * @return ShippingDetails
     */
    public function setVendor(\Venture\VendorBundle\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;
    
        return $this;
    }

    /**
     * Get vendor
     *
     * @return \Venture\VendorBundle\Entity\Vendor 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set shipping_method
     *
     * @param \Settings\ConfigBundle\Entity\ShippingMethod $shippingMethod
     * @return ShippingDetails
     */
    public function setShippingMethod(\Settings\ConfigBundle\Entity\ShippingMethod $shippingMethod = null)
    {
        $this->shipping_method = $shippingMethod;
    
        return $this;
    }

    /**
     * Get shipping_method
     *
     * @return \Settings\ConfigBundle\Entity\ShippingMethod 
     */
    public function getShippingMethod()
    {
        return $this->shipping_method;
    }

    /**
     * Set packaging
     *
     * @param \Settings\ConfigBundle\Entity\Packaging $packaging
     * @return ShippingDetails
     */
    public function setConfigPackaging(\Settings\ConfigBundle\Entity\Packaging $configPackaging = null)
    {
        $this->configPackaging = $configPackaging;
    
        return $this;
    }

    /**
     * Get packaging
     *
     * @return \Settings\ConfigBundle\Entity\Packaging 
     */
    public function getConfigPackaging()
    {
        return $this->configPackaging;
    }

    /**
     * Set raw_material
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterial
     * @return ShippingDetails
     */
    public function setRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterial = null)
    {
        $this->raw_material = $rawMaterial;
    
        return $this;
    }

    /**
     * Get raw_material
     *
     * @return \Venture\RawMaterialsBundle\Entity\RawMaterials 
     */
    public function getRawMaterial()
    {
        return $this->raw_material;
    }

    /**
     * Set total_cost
     *
     * @param integer $totalCost
     * @return ShippingDetails
     */
    public function setTotalCost($totalCost)
    {
        $this->total_cost = $totalCost;
    
        return $this;
    }

    /**
     * Get total_cost
     *
     * @return integer 
     */
    public function getTotalCost()
    {
        return $this->total_cost;
    }

    /**
     * Set cost_per_unit
     *
     * @param integer $costPerUnit
     * @return ShippingDetails
     */
    public function setCostPerUnit($costPerUnit)
    {
        $this->cost_per_unit = $costPerUnit;
    
        return $this;
    }

    /**
     * Get cost_per_unit
     *
     * @return integer 
     */
    public function getCostPerUnit()
    {
        return $this->cost_per_unit;
    }
    
    public function setVenturePackaging(\Venture\PackagingBundle\Entity\Packaging $venturePackaging = null) {
        $this->venturePackaging = $venturePackaging;
        return $this;
    }

    public function getVenturePackaging() {
        return $this->venturePackaging;
    }
    

    /**
     * Set alternateRawMaterial
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterial
     * @return ShippingDetails
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