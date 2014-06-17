<?php

namespace Venture\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tag
 *
 * @ORM\Table(name="ven_tags")
 * @ORM\Entity(repositoryClass="Venture\CommonBundle\Entity\Repository\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="Venture\FinishedProductBundle\Entity\FinishedProduct", inversedBy="tags", cascade={"all"})
     * @ORM\JoinTable(name="ven_finished_products_tags",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="finished_product_id", referencedColumnName="id")}
     *      )
     **/  
    protected $finishedProducts;
    
    /**
     * @ORM\ManyToMany(targetEntity="Venture\IntermediateBundle\Entity\Intermediate", inversedBy="tags", cascade={"all"})
     * @ORM\JoinTable(name="ven_intermediates_tags",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="intermediate_id", referencedColumnName="id")}
     *      )
     **/  
    protected $intermediates;

    /**
     * @ORM\ManyToMany(targetEntity="\Venture\PackagingBundle\Entity\Packaging", inversedBy="tags", cascade={"all"})
     * @ORM\JoinTable(name="ven_packagings_tags",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="packaging_id", referencedColumnName="id")}
     *      )
     **/
    protected $packagings;

    
    public function __construct() {
        $this->finishedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intermediates    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packagings       = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tag
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
    
    public function addFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct) {
        $this->finishedProducts[] = $finishedProduct;
        return $this;
    }

    public function removeFinishedProduct(\Venture\FinishedProductBundle\Entity\FinishedProduct $finishedProduct) {
        $this->finishedProducts->removeElement($finishedProduct);
    }

    public function getFinishedProducts() {
        return $this->finishedProducts;
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
     * Add packagings
     *
     * @param \Venture\PackagingBundle\Entity\Packaging $packagings
     * @return Tag
     */
    public function addPackaging(\Venture\PackagingBundle\Entity\Packaging $packagings)
    {
        $this->packagings[] = $packagings;

        return $this;
    }

    /**
     * Remove packagings
     *
     * @param \Venture\PackagingBundle\Entity\Packaging $packagings
     */
    public function removePackaging(\Venture\PackagingBundle\Entity\Packaging $packagings)
    {
        $this->packagings->removeElement($packagings);
    }

    /**
     * Get packagings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackagings()
    {
        return $this->packagings;
    }
}
