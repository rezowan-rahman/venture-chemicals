<?php

namespace Venture\FinishedProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class FinishedProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemNumber', 'text', array("label" => "Item Number", "required" => true))
            ->add('itemName', 'text', array("label" => "Item Name", "required" => true))
            ->add('itemDescription', 'text', array("label" => "Description", "required" => true))
            ->add('reasonForChange', 'text', array("label" => "Reason for Change", "required" => true))
            ->add('tags', 'tag', array("label" => "Tags/Keywords", "required" => false))
            ->add('reorderPoint', 'text', array("label" => "Recommended Stock Level", "required" => true))
            ->add('standardCost', 'text', array("label" => 'Standard Price', "required" => true))
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
            ->add('formulas', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\FormulaType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            ))
            ->add('salesPointCosts', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\SalesPointCostType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            ))
           
            ->add('competitiveProducts','entity', array(
                'class' => 'VentureCompetitiveProductBundle:CompetitiveProduct',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('cp')
                                ->select('cp')
                                ->where('cp.isActive = :active')->setParameter('active', 1)
                                ->orderBy('cp.itemName', 'ASC');
                },
                'empty_value' => 'Choose a Competitive Product',
                'property' => 'itemName',
                "label" => "Competitive Products",
                'multiple'  => true,
                'required' => false,
                "attr" => array('class' => 'selectBoxWidthFix heightFix')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\FinishedProductBundle\Entity\FinishedProduct'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_finishedproductbundle_finishedproduct';
    }
}
