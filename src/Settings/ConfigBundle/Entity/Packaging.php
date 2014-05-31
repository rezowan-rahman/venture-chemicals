<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

use Venture\CompetitiveProductBundle\Entity\CompetitiveProduct;

/**
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\PackagingRepository")
 * @ORM\Table(name="ven_packaging")
 * @ORM\HasLifecycleCallbacks
 */
class Packaging
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $value;
    
    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $weighsIn;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $approved;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\ShippingDetails", mappedBy="configPackaging", cascade={"all"})
     */
    protected $shipping_details;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\FinishedProductBundle\Entity\FinishedProduct", mappedBy="configPackaging", cascade={"all"})
     */
    protected $finishedProducts;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CompetitiveProductBundle\Entity\CompetitiveProduct", mappedBy="configPackaging", cascade={"all"})
     */
    protected $competitiveProducts;

    public function __construct()
    {
        $this->shipping_details = new \Doctrine\Common\Collections\ArrayCollection();
        $this->finishedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competitiveProducts = new \Doctrine\Common\Collections\ArrayCollection();
                
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
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
     * Set name
     *
     * @param string $name
     * @return Property
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return Property
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    
        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Property
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Property
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
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
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'You must fill the name value up'
        )));
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
    
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }
    
    public function setWeighsIn($weighsIn) {
        $this->weighsIn = $weighsIn;
        return $this;
    }

    public function getWeighsIn() {
        return $this->weighsIn;
    }
    
    public function addFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct) {
        $this->finishedProducts[] = $finishedProduct;
        return $this;
    }
    
    public function removeFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct) {
        $this->finishedProducts->removeElement($finishedProduct);
    }
    
    public function getFinishedProducts() {
        return $this->finishedProducts;
    }
    
    public function addCompetitiveProduct(CompetitiveProduct $obj) {
        $this->competitiveProducts[] = $obj;
        return $this;
    }
    
    public function removeCompetitiveProduct(CompetitiveProduct $obj) {
        $this->competitiveProducts->removeElement($obj);
    }
    
    public function getCompetitiveProducts() {
        return $this->competitiveProducts;
    }
}