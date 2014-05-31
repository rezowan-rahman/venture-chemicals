<?php

namespace Venture\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Rule;

/**
 * Customer
 *
 * @ORM\Table(name="ven_customer")
 * @ORM\Entity(repositoryClass="Venture\CustomerBundle\Entity\Repository\CustomerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Customer
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
     * @ORM\Column(name="name", type="string", length=60)
     * @Rule\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address_1", type="string", length=255)
     */
    private $streetAddress1;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address_2", type="string", length=255)
     */
    private $streetAddress2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     * @Rule\NotBlank
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=20)
     * @Rule\NotBlank
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=10)
     * @Rule\NotBlank
     * @Rule\Type("integer")
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100)
     * @Rule\NotBlank
     * @Rule\Url
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=50)
     * @Rule\NotBlank
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_1", type="string", length=100)
     * @Rule\NotBlank
     */
    private $contact1;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_2", type="string", length=100, nullable=true)
     */
    private $contact2;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_1_email", type="string", length=100)
     * @Rule\NotBlank
     * @Rule\Email
     */
    private $contact1Email;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_2_email", type="string", length=100, nullable=true)
     * @Rule\Email
     */
    private $contact2Email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
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
     * @ORM\ManyToOne(targetEntity="\Venture\CustomerBundle\Entity\Customer", inversedBy="children")
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CustomerBundle\Entity\Customer", mappedBy="parent")
     */
    protected $children;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\PipeLineBundle\Entity\PipeLine", mappedBy="customer")
     */
    protected $pipeLines;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pipeLines = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Customer
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
     * Set streetAddress1
     *
     * @param string $streetAddress1
     * @return Customer
     */
    public function setStreetAddress1($streetAddress1)
    {
        $this->streetAddress1 = $streetAddress1;
    
        return $this;
    }

    /**
     * Get streetAddress1
     *
     * @return string 
     */
    public function getStreetAddress1()
    {
        return $this->streetAddress1;
    }

    /**
     * Set streetAddress2
     *
     * @param string $streetAddress2
     * @return Customer
     */
    public function setStreetAddress2($streetAddress2)
    {
        $this->streetAddress2 = $streetAddress2;
    
        return $this;
    }

    /**
     * Get streetAddress2
     *
     * @return string 
     */
    public function getStreetAddress2()
    {
        return $this->streetAddress2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Customer
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
     * @return Customer
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
     * Set zipCode
     *
     * @param string $zipCode
     * @return Customer
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    
        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Customer
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Customer
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set contact1
     *
     * @param string $contact1
     * @return Customer
     */
    public function setContact1($contact1)
    {
        $this->contact1 = $contact1;
    
        return $this;
    }

    /**
     * Get contact1
     *
     * @return string 
     */
    public function getContact1()
    {
        return $this->contact1;
    }

    /**
     * Set contact2
     *
     * @param string $contact2
     * @return Customer
     */
    public function setContact2($contact2)
    {
        $this->contact2 = $contact2;
    
        return $this;
    }

    /**
     * Get contact2
     *
     * @return string 
     */
    public function getContact2()
    {
        return $this->contact2;
    }

    /**
     * Set contact1Email
     *
     * @param string $contact1Email
     * @return Customer
     */
    public function setContact1Email($contact1Email)
    {
        $this->contact1Email = $contact1Email;
    
        return $this;
    }

    /**
     * Get contact1Email
     *
     * @return string 
     */
    public function getContact1Email()
    {
        return $this->contact1Email;
    }

    /**
     * Set contact2Email
     *
     * @param string $contact2Email
     * @return Customer
     */
    public function setContact2Email($contact2Email)
    {
        $this->contact2Email = $contact2Email;
    
        return $this;
    }

    /**
     * Get contact2Email
     *
     * @return string 
     */
    public function getContact2Email()
    {
        return $this->contact2Email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Customer
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
    
    public function getCreated() {
        return $this->created;
    }

    public function getUpdated() {
        return $this->updated;
    }
    
    public function setParent(Customer $obj=null) {
        $this->parent = $obj;
        return $this;
    }
    
    public function getParent() {
        return $this->parent;
    }
    
    public function addChild(Customer $obj) {
        $this->children[] = $obj;
        return $this;
    }

    public function removeChild(Customer $obj) {
        $this->children->removeElement($obj);
    }
    
    public function getChildren() {
        return $this->children;
    }
    
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }
    
    public function getNote() {
        return $this->note;
    }
    
    
    /**
     * Add pipeLines
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLine $pipeLines
     * @return Customer
     */
    public function addPipeLine(\Venture\PipeLineBundle\Entity\PipeLine $pipeLines)
    {
        $this->pipeLines[] = $pipeLines;
    
        return $this;
    }

    /**
     * Remove pipeLines
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLine $pipeLines
     */
    public function removePipeLine(\Venture\PipeLineBundle\Entity\PipeLine $pipeLines)
    {
        $this->pipeLines->removeElement($pipeLines);
    }

    /**
     * Get pipeLines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPipeLines()
    {
        return $this->pipeLines;
    }
}