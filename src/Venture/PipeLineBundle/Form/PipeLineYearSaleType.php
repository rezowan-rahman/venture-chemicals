<?php

namespace Venture\PipeLineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PipeLineYearSaleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('firstQt', null, array())
            ->add('secondQt', null, array())
            ->add('thirdQt', null, array())
            ->add('fourthQt', null, array())
            ->add('total', null, array())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\PipeLineBundle\Entity\PipeLineYearSale'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_pipelinebundle_pipelineyearsale';
    }
}
