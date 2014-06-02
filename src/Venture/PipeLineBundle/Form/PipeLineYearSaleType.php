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
            ->add('year', 'choice', array(
                "label" => false,
                "choices" => range(date('Y'), (date('Y')-5)),
                "empty_value" => "Choose A Year"
            ))

            ->add('firstQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "1st Qtr",
                    "class" => "firstQt"
                )
            ))

            ->add('secondQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "2nd Qtr",
                    "class" => "secondQt"
                )
            ))

            ->add('thirdQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "3rd Qtr",
                    "class" => "thirdQt"
                )
            ))

            ->add('fourthQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "4th Qtr",
                    "class" => "fourthQt"
                )
            ))

            ->add('total', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "Summation",
                    "readonly" => true,
                    "class" => "total"
                )
            ))
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
