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
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\UnitOfMeasureRepository")
 * @ORM\Table(name="ven_unit_of_measure")
 * @ORM\HasLifecycleCallbacks
 */
class UnitOfMeasure
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
     * @ORM\OneToMany(targetEntity="\Venture\RawMaterialsBundle\Entity\RawMaterials", mappedBy="unit_of_measure", cascade={"all"})
     */
    protected $raw_materials;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\PackagingBundle\Entity\Packaging", mappedBy="unit_of_measure", cascade={"all"})
     */
    protected $packaging;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\IntermediateBundle\Entity\Intermediate", mappedBy="unitOfMeasure", cascade={"all"})
     */
    protected $intermediates;
    
    /**
     * @ORM\OneToMany(targetEntity="\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial", mappedBy="unitOfMeasure", cascade={"all"})
     */
    protected $alternateRawMaterials;
    

    public function __construct()
    {
        $this->intermediates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->raw_materials = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packaging = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alternateRawMaterials = new \Doctrine\Common\Collections\ArrayCollection();
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
            'message' => 'You must fill the name value up'
        )));
    }

    /**
     * Add raw_materials
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials
     * @return UnitOfMeasure
     */
    public function addRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->raw_materials[] = $rawMaterials;
    
        return $this;
    }

    /**
     * Remove raw_materials
     *
     * @param \Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials
     */
    public function removeRawMaterial(\Venture\RawMaterialsBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->raw_materials->removeElement($rawMaterials);
    }

    /**
     * Get raw_materials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterials()
    {
        return $this->raw_materials;
    }

    /**
     * Add packaging
     *
     * @param \Venture\PackagingBundle\Entity\Packaging $packaging
     * @return UnitOfMeasure
     */
    public function addPackaging(\Venture\PackagingBundle\Entity\Packaging $packaging)
    {
        $this->packaging[] = $packaging;
    
        return $this;
    }

    /**
     * Remove packaging
     *
     * @param \Venture\PackagingBundle\Entity\Packaging $packaging
     */
    public function removePackaging(\Venture\PackagingBundle\Entity\Packaging $packaging)
    {
        $this->packaging->removeElement($packaging);
    }

    /**
     * Get packaging
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackaging()
    {
        return $this->packaging;
    }

    

    public function addIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediate) {
        $this->intermediates[] = $intermediate;
        return $this;
    }
    
    public function removeIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediate) {
        $this->intermediates->removeElement($intermediate);
    }
    
    public function getIntermediates() {
        return $this->intermediates;
    }

    /**
     * Add alternateRawMaterials
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials
     * @return UnitOfMeasure
     */
    public function addAlternateRawMaterial(\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials)
    {
        $this->alternateRawMaterials[] = $alternateRawMaterials;
    
        return $this;
    }

    /**
     * Remove alternateRawMaterials
     *
     * @param \Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials
     */
    public function removeAlternateRawMaterial(\Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial $alternateRawMaterials)
    {
        $this->alternateRawMaterials->removeElement($alternateRawMaterials);
    }

    /**
     * Get alternateRawMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlternateRawMaterials()
    {
        return $this->alternateRawMaterials;
    }
}