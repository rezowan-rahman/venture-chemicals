<?php

namespace Venture\PackagingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class PackagingType extends AbstractType
{
    private $unitOfmeasure;
            
    public function __construct($unitOfmeasure) {
        $this->unitOfmeasure = $unitOfmeasure;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item_number', 'text', array("label" => "Item Number"))
            ->add('item_name', 'text', array("label" => "Item Name"))
            ->add('description', 'text', array("label" => "Description"))
            ->add('unit_of_measure', 'entity', array(
                "class" => 'SettingsConfigBundle:UnitOfMeasure',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')    
                                ->select('u')
                                ->where('u.approved = :active')->setParameter('active', 1)
                                ->orderBy('u.name', 'ASC');
                    },
                "empty_value" => "Choose a Unit",
                "property" => "name",
                "label" => "Unit of Measure",
                "data" => $this->unitOfmeasure           
            ))    
            ->add('tags', 'text', array("label" => "Tags, Keywords: Seperate by Comma", "required" => false)) 
            ->add('shipping_details', 'collection', array(
                "type"      => new \Venture\PackagingBundle\Form\Type\ShippingDetailsType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('reorder_point', 'text', array("label" => "Re-Order Point", "required" => false))
            ->add('is_active', 'checkbox', array("label" => "Active", "required" => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\PackagingBundle\Entity\Packaging'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'packaging_details';
    }
}