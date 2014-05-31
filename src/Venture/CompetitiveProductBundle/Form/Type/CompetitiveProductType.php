<?php

namespace Venture\CompetitiveProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class CompetitiveProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('itemName', 'text', array("label" => "Item Name", "required" => true))
            ->add('itemDescription', 'text', array("label" => "Description", "required" => true))
            ->add('itemSupplier', 'text', array("label" => "Supplier", "required" => true))
            ->add('tags', 'text', array("label" => "Tags, Keywords: Seperate by Comma", "required" => true)) 
            ->add('standardCost', 'text', array("label" => "Standard Price", "required" => true))
            ->add('isActive', 'checkbox', array("label" => "Active", "required" => false))
            ->add('configPackaging', 'entity', array(
                "class" => 'SettingsConfigBundle:Packaging',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')    
                                ->select('p')
                                ->where('p.approved = :active')->setParameter('active', 1)
                                ->orderBy('p.name', 'ASC');
                    },
                "empty_value" => "Choose a packaging",
                "property" => "name",
                "label" => "Packaging",
                "required" => true
            ))
            ->add('properties', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\PropertyType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\CompetitiveProductBundle\Entity\CompetitiveProduct'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_competitiveproductbundle_competitiveproduct';
    }
}
