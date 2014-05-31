<?php

namespace Venture\AlternateRawMaterialBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class AlternateRawMaterialType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemName', 'text', array("label" => "Item Name"))
            ->add('itemDescription', 'text', array("label" => "Description"))
            ->add('unitOfMeasure', 'entity', array(
                "class" => 'SettingsConfigBundle:UnitOfMeasure',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')    
                                ->select('u')
                                ->where('u.approved = :active')->setParameter('active', 1)
                                ->orderBy('u.name', 'ASC');
                    },
                "empty_value" => "Choose a Unit",
                "property" => "name",
                "label" => "Unit of Measure"
            ))    
            ->add('tags', 'text', array("label" => "Tags, Keywords: Seperate by Comma", "required" => false)) 
            ->add('properties', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\PropertyType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('orderingDetails', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\ShippingDetailsType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('isActive', 'checkbox', array("label" => "Active", "required" => false))
                            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_alternaterawmaterialbundle_alternaterawmaterial';
    }
}
