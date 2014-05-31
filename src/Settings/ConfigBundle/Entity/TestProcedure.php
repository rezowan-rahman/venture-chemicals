<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\TestProcedureRepository")
 * @ORM\Table(name="ven_test_procedure")
 * @ORM\HasLifecycleCallbacks
 */
class TestProcedure
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    protected $description;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $approved;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * @Assert\File(maxSize="5M")
     */
    private $file;
    
    private $temp;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\CommonBundle\Entity\Property", mappedBy="testProcedure", cascade={"all"})
     */
    protected $commonProperties;
    
    public function __construct() {
        
        $this->commonProperties = new \Doctrine\Common\Collections\ArrayCollection();
                
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue() {
       $this->setUpdated(new \DateTime());
    }
    
    
    /**
     * Set path
     *
     * @param string $path
     * @return TestProcedure
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }
    
    
    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }
    
    /*
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        
        if (isset($this->path)) {
            $this->temp = $this->path;
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
        } else {
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
        }
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }
    
    
    
    
    public function getAbsolutePath() {
        return (null === $this->path)
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir() {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir() {
        return "uploads/test_procedure_documents";
    }
    
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }
        
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        if (isset($this->temp)) {
            unlink($this->getUploadRootDir().'/'.$this->temp);
            $this->temp = null;
        }
        
        $this->file = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
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
     * @return TestProcedure
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
     * Set description
     *
     * @param string $description
     * @return TestProcedure
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
     * Set approved
     *
     * @param boolean $approved
     * @return TestProcedure
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
     * @return TestProcedure
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
     * @return TestProcedure
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
}