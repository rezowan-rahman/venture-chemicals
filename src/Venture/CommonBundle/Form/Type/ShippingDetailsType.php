<?php

namespace Venture\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class ShippingDetailsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vendor', 'entity', array(
                "class" => 'VentureVendorBundle:Vendor',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('v')    
                                ->select('v')
                                ->where('v.active = :active')->setParameter('active', 1)
                                ->orderBy('v.name', 'ASC');
                    },
                "empty_value" => "Choose a vendor",
                "property" => "name",
                "label" => "Vendor(s)",
                "required" => true
            )) 
            ->add('shipping_method', 'entity', array(
                "class" => 'SettingsConfigBundle:ShippingMethod',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('sm')    
                                ->select('sm')
                                ->where('sm.approved = :active')->setParameter('active', 1)
                                ->orderBy('sm.name', 'ASC');
                    },
                "empty_value" => "Choose a shipping method",
                "property" => "name",
                "label" => "Shipping Method",
                "required" => true
            )) 
            ->add('lead_time', "text", array("label" => "Lead time", "required" => true))
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
                "label" => "Packaging Type",
                "required" => true
            ))
            ->add('amount_shipped', "number", array("label" => "Amount Shipped(UoM)" , "required" => true, "attr" => array(
                "class" => "amount_shipped"
            )))
            ->add('pre_freight_cost', "number", array("label" => "Pre - Freight Cost", "required" => true, "attr" => array(
                "class" => "pre_freight_cost"
            )))  
            ->add('freight_cost', "number", array("label" => "Freight Cost", "required" => true, "attr" => array(
                "class" => "freight_cost"
            )))
            ->add('total_cost', "number", array("label" => "Total Cost", "required" => true, "attr" => array(
                "class" => "total_cost", 
                "onfocus" => "calculateTotalCost(this)",
                "readonly" => "readonly"
             )))
             ->add('cost_per_unit', "number", array("label" => "Cost/UoM", "required" => true, "attr" => array(
                "class" => "cost_per_unit", 
                "onfocus" => "calculateCostPerUnit(this)",
                "readonly" => "readonly"
            )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\CommonBundle\Entity\ShippingDetails'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shippingdetails';
    }
}