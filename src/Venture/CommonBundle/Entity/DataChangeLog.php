<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * DataChangeLog
 *
 * @ORM\Table(name="ven_common_change_logs")
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\DataChangeLogRepository")
 * @ORM\HasLifecycleCallbacks
 */
class DataChangeLog
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
     * @ORM\Column(name="reason_for_change", type="string", length=255)
     */
    private $reasonForChange;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="logged_at", type="datetime")
     */
    private $loggedAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="changeLogs")
     * @ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")
     */
    private $finishedProduct;
    
    /**
     * @ORM\ManyToOne(targetEntity="Venture\IntermediateBundle\Entity\Intermediate", inversedBy="changeLogs")
     * @ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")
     */
    private $intermediate;

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
     * Set reasonForChange
     *
     * @param string $reasonForChange
     * @return DataChangeLog
     */
    public function setReasonForChange($reasonForChange)
    {
        $this->reasonForChange = $reasonForChange;
    
        return $this;
    }

    /**
     * Get reasonForChange
     *
     * @return string 
     */
    public function getReasonForChange()
    {
        return $this->reasonForChange;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return DataChangeLog
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    public function setLoggedAt($loggedAt) {
        $this->loggedAt = $loggedAt;
        return $this;
    }
    /**
     * Get loggedAt
     *
     * @return \DateTime 
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
    }
    
    public function setFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct = null) {
        $this->finishedProduct = $finishedProduct;
        return $this;
    }
    
    public function getFinishedProduct() {
        return $this->finishedProduct;
    }
    
    public function setIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediate = null) {
        $this->intermediate = $intermediate;
        return $this;
    }
    
    public function getIntermediate() {
        return $this->intermediate;
    }
}
