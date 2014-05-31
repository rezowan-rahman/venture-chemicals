<?php

namespace Settings\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalesPricePointType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salesCostPoint', 'text', array('label' => "Sales Price Point", 'required' => true))
            ->add('description', 'text', array('label' => "Description", 'required' => true))
            ->add('approved', 'checkbox', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Settings\ConfigBundle\Entity\SalesPricePoint'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_configbundle_salespricepoint';
    }
}
