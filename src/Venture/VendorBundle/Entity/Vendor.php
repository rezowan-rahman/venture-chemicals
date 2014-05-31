<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Venture\VendorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Type;

/**
 * @ORM\Entity(repositoryClass="Venture\VendorBundle\Entity\Repository\VendorRepository")
 * @ORM\Table(name="ven_vendor")
 * @ORM\HasLifecycleCallbacks
 */
class Vendor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $supplier_since;
    
    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $street_1;
    
    /**
     * @ORM\Column(type="string", length=200, nullable = true)
     */
    protected $street_2;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $city;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $state;
    
    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $zip_code;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $website;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $contact_1;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $contact_1_email;
    
    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $contact_2;
    
    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $contact_2_email;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;
    
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
     * @ORM\ManyToOne(targetEntity="Vendor", inversedBy="children")
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Vendor", mappedBy="parent")
     */
    protected $children;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\ShippingDetails", mappedBy="vendor", cascade={"all"})
     */
    protected $shipping_details;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;
    
    
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('supplier_since', new NotBlank());
        $metadata->addPropertyConstraint('city', new NotBlank());
        $metadata->addPropertyConstraint('state', new NotBlank());
        
        $metadata->addPropertyConstraint('zip_code', new NotBlank());
        $metadata->addPropertyConstraint('zip_code', new Type("integer"));
        
        $metadata->addPropertyConstraint('website', new NotBlank());
        $metadata->addPropertyConstraint('website', new Url());
        
        $metadata->addPropertyConstraint('phone', new NotBlank());
        $metadata->addPropertyConstraint('contact_1', new NotBlank());
        
        $metadata->addPropertyConstraint('contact_1_email', new NotBlank());
        $metadata->addPropertyConstraint('contact_1_email', new Email());
     
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shipping_details = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packaging_shipping_details = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Vendor
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
     * Set supplier_since
     *
     * @param string $supplierSince
     * @return Vendor
     */
    public function setSupplierSince($supplierSince)
    {
        $this->supplier_since = $supplierSince;
    
        return $this;
    }

    /**
     * Get supplier_since
     *
     * @return string 
     */
    public function getSupplierSince()
    {
        return $this->supplier_since;
    }

    /**
     * Set street_1
     *
     * @param string $street1
     * @return Vendor
     */
    public function setStreet1($street1)
    {
        $this->street_1 = $street1;
    
        return $this;
    }

    /**
     * Get street_1
     *
     * @return string 
     */
    public function getStreet1()
    {
        return $this->street_1;
    }

    /**
     * Set street_2
     *
     * @param string $street2
     * @return Vendor
     */
    public function setStreet2($street2)
    {
        $this->street_2 = $street2;
    
        return $this;
    }

    /**
     * Get street_2
     *
     * @return string 
     */
    public function getStreet2()
    {
        return $this->street_2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Vendor
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Vendor
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip_code
     *
     * @param string $zipCode
     * @return Vendor
     */
    public function setZipCode($zipCode)
    {
        $this->zip_code = $zipCode;
    
        return $this;
    }

    /**
     * Get zip_code
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Vendor
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Vendor
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set contact_1
     *
     * @param string $contact1
     * @return Vendor
     */
    public function setContact1($contact1)
    {
        $this->contact_1 = $contact1;
    
        return $this;
    }

    /**
     * Get contact_1
     *
     * @return string 
     */
    public function getContact1()
    {
        return $this->contact_1;
    }

    /**
     * Set contact_1_email
     *
     * @param string $contact1Email
     * @return Vendor
     */
    public function setContact1Email($contact1Email)
    {
        $this->contact_1_email = $contact1Email;
    
        return $this;
    }

    /**
     * Get contact_1_email
     *
     * @return string 
     */
    public function getContact1Email()
    {
        return $this->contact_1_email;
    }

    /**
     * Set contact_2
     *
     * @param string $contact2
     * @return Vendor
     */
    public function setContact2($contact2)
    {
        $this->contact_2 = $contact2;
    
        return $this;
    }

    /**
     * Get contact_2
     *
     * @return string 
     */
    public function getContact2()
    {
        return $this->contact_2;
    }

    /**
     * Set contact_2_email
     *
     * @param string $contact2Email
     * @return Vendor
     */
    public function setContact2Email($contact2Email)
    {
        $this->contact_2_email = $contact2Email;
    
        return $this;
    }

    /**
     * Get contact_2_email
     *
     * @return string 
     */
    public function getContact2Email()
    {
        return $this->contact_2_email;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Vendor
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
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
     * Set parent
     *
     * @param \Venture\VendorBundle\Entity\Vendor $parent
     * @return Vendor
     */
    public function setParent(\Venture\VendorBundle\Entity\Vendor $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Venture\VendorBundle\Entity\Vendor 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Venture\VendorBundle\Entity\Vendor $children
     * @return Vendor
     */
    public function addChildren(\Venture\VendorBundle\Entity\Vendor $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Venture\VendorBundle\Entity\Vendor $children
     */
    public function removeChildren(\Venture\VendorBundle\Entity\Vendor $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
    

    /**
     * Add shipping_details
     *
     * @param \Venture\CommonBundle\Entity\ShippingDetails $shippingDetails
     * @return Vendor
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
    
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }
    
    public function getNote() {
        return $this->note;
    }
}