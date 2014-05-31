<?php

namespace Venture\PipeLineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PipeLineYearSale
 *
 * @ORM\Table(name="ven_pipepline_year_sales")
 * @ORM\Entity(repositoryClass="Venture\PipeLineBundle\Entity\Repository\PipeLineYearSaleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PipeLineYearSale
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
     * @var \DateTime
     *
     * @ORM\Column(name="year", type="date")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="firstQt", type="string", length=30)
     */
    private $firstQt;

    /**
     * @var string
     *
     * @ORM\Column(name="secondQt", type="string", length=30)
     */
    private $secondQt;

    /**
     * @var string
     *
     * @ORM\Column(name="thirdQt", type="string", length=30)
     */
    private $thirdQt;

    /**
     * @var string
     *
     * @ORM\Column(name="fourthQt", type="string", length=30)
     */
    private $fourthQt;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=30)
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Venture\PipeLineBundle\Entity\PipeLine", inversedBy="yearSales")
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
     * Set year
     *
     * @param \DateTime $year
     * @return PipeLineYearSale
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set firstQt
     *
     * @param string $firstQt
     * @return PipeLineYearSale
     */
    public function setFirstQt($firstQt)
    {
        $this->firstQt = $firstQt;
    
        return $this;
    }

    /**
     * Get firstQt
     *
     * @return string 
     */
    public function getFirstQt()
    {
        return $this->firstQt;
    }

    /**
     * Set secondQt
     *
     * @param string $secondQt
     * @return PipeLineYearSale
     */
    public function setSecondQt($secondQt)
    {
        $this->secondQt = $secondQt;
    
        return $this;
    }

    /**
     * Get secondQt
     *
     * @return string 
     */
    public function getSecondQt()
    {
        return $this->secondQt;
    }

    /**
     * Set thirdQt
     *
     * @param string $thirdQt
     * @return PipeLineYearSale
     */
    public function setThirdQt($thirdQt)
    {
        $this->thirdQt = $thirdQt;
    
        return $this;
    }

    /**
     * Get thirdQt
     *
     * @return string 
     */
    public function getThirdQt()
    {
        return $this->thirdQt;
    }

    /**
     * Set fourthQt
     *
     * @param string $fourthQt
     * @return PipeLineYearSale
     */
    public function setFourthQt($fourthQt)
    {
        $this->fourthQt = $fourthQt;
    
        return $this;
    }

    /**
     * Get fourthQt
     *
     * @return string 
     */
    public function getFourthQt()
    {
        return $this->fourthQt;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return PipeLineYearSale
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
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
     * @return PipeLineYearSale
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