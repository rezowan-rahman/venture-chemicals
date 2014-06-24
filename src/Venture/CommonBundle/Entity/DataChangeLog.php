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
     * @ORM\ManyToMany(targetEntity="\Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="changeLogs", cascade={"all"})
     * @ORM\JoinTable(name="ven_finished_products_logs",
     *      joinColumns={@ORM\JoinColumn(name="log_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")}
     *      )
     **/
    protected $finishedProducts;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\IntermediateBundle\Entity\Intermediate", inversedBy="changeLogs", cascade={"all"})
     * @ORM\JoinTable(name="ven_intermediates_logs",
     *      joinColumns={@ORM\JoinColumn(name="log_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")}
     *      )
     **/
    protected $intermediates;



    public function __construct() {
        $this->finishedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intermediates = new \Doctrine\Common\Collections\ArrayCollection();
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
    


    /**
     * Add finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     * @return DataChangeLog
     */
    public function addFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts)
    {
        $this->finishedProducts[] = $finishedProducts;

        return $this;
    }

    /**
     * Remove finishedProducts
     *
     * @param \Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts
     */
    public function removeFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProducts)
    {
        $this->finishedProducts->removeElement($finishedProducts);
    }

    /**
     * Get finishedProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinishedProducts()
    {
        return $this->finishedProducts;
    }

    /**
     * Add intermediates
     *
     * @param \Venture\IntermediateBundle\Entity\Intermediate $intermediates
     * @return DataChangeLog
     */
    public function addIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediates)
    {
        $this->intermediates[] = $intermediates;

        return $this;
    }

    /**
     * Remove intermediates
     *
     * @param \Venture\IntermediateBundle\Entity\Intermediate $intermediates
     */
    public function removeIntermediate(\Venture\IntermediateBundle\Entity\Intermediate $intermediates)
    {
        $this->intermediates->removeElement($intermediates);
    }

    /**
     * Get intermediates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntermediates()
    {
        return $this->intermediates;
    }
}
