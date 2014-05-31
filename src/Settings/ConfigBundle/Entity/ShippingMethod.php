<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\ShippingMethodRepository")
 * @ORM\Table(name="ven_shipping_method")
 * @ORM\HasLifecycleCallbacks
 */
class ShippingMethod
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
     * @ORM\Column(type="boolean")
     */
    protected $approved;

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
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\ShippingDetails", mappedBy="shipping_method", cascade={"all"})
     */
    protected $shipping_details;
    
    

    public function __construct()
    {
        $this->shipping_details = new \Doctrine\Common\Collections\ArrayCollection();
       
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
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'You must fill the shipping method value up'
        )));
    }

    /**
     * Add shipping_details
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $shippingDetails
     * @return ShippingMethod
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ShippingMethod
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ShippingMethod
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }
}