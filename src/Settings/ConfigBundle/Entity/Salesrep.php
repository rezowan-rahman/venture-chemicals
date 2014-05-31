<?php

namespace Settings\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Salesrep
 *
 * @ORM\Table(name="ven_config_sales_rep")
 * @ORM\Entity(repositoryClass="Settings\ConfigBundle\Entity\Repository\SalesrepRepository")
 */
class Salesrep
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
     * @ORM\OneToMany(targetEntity="\Venture\PipeLineBundle\Entity\PipeLine", mappedBy="salesRep")
     */
    protected $pipeLines;


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
     * @return Salesrep
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
     * @return Salesrep
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
     * Constructor
     */
    public function __construct()
    {
        $this->pipeLines = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add pipeLines
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLine $pipeLines
     * @return Salesrep
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