<?php

namespace Settings\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnitOfMeasureType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', 'text', array('label' => "Unit of Measure", 'required' => true))
            ->add('approved', 'checkbox', array('required' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Settings\ConfigBundle\Entity\UnitOfMeasure'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_configbundle_unitofmeasure';
    }
}
