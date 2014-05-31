<?php

namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Stage
 *
 * @ORM\Table(name="ven_config_stages")
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\StageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Stage
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
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
     * @ORM\OneToMany(targetEntity="\Venture\PipeLineBundle\Entity\PipeLine", mappedBy="stage")
     */
    protected $pipeLines;
    
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return Stage
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Stage
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
    
    
    /**
     * Add pipeLines
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLine $pipeLines
     * @return Stage
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