<?php

namespace Settings\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductLineType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                "label" => "Product Line",
            ))
            ->add('isActive', null, array(
                "required" => false,
                "label" => "Approved",
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Settings\ConfigBundle\Entity\ProductLine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_configbundle_productline';
    }
}
