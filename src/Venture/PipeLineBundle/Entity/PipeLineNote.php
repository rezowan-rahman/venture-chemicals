<?php

namespace Venture\PipeLineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PipeLineNote
 *
 * @ORM\Table(name="ven_pipeline_notes")
 * @ORM\Entity(repositoryClass="Venture\PipeLineBundle\Entity\Repository\PipeLineNoteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PipeLineNote
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
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Venture\PipeLineBundle\Entity\PipeLine", inversedBy="notes")
     * @ORM\JoinColumn(name="pipe_line_id", referencedColumnName="id")
     */
    protected $pipeLine;


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
     * Set body
     *
     * @param string $body
     * @return PipeLineNote
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
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
     * Set pipeLine
     *
     * @param \Venture\PipeLineBundle\Entity\PipeLine $pipeLine
     * @return PipeLineNote
     */
    public function setPipeLine(\Venture\PipeLineBundle\Entity\PipeLine $pipeLine = null)
    {
        $this->pipeLine = $pipeLine;
    
        return $this;
    }

    /**
     * Get pipeLine
     *
     * @return \Venture\PipeLineBundle\Entity\PipeLine 
     */
    public function getPipeLine()
    {
        return $this->pipeLine;
    }
}