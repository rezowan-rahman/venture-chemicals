<?php

namespace Settings\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PackagingType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => "Label", 'required' => true))
            ->add('value', 'text', array('label' => "Amount", 'required' => true)) 
            ->add('weighsIn', 'text', array('label' => "Unit", 'required' => true))     
            ->add('approved', 'checkbox', array('required' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Settings\ConfigBundle\Entity\Packaging'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_configbundle_packaging';
    }
}
