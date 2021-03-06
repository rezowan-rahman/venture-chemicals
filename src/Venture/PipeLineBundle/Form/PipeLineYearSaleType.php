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
                "choices" => $this->getYears(date("Y"), 5),
                "empty_value" => "Year"
            ))

            ->add('firstQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "1st Qtr"
                )
            ))

            ->add('secondQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "2nd Qtr",
                )
            ))

            ->add('thirdQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "3rd Qtr",
                )
            ))

            ->add('fourthQt', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "4th Qtr",
                )
            ))

            ->add('total', 'number', array(
                "label" => false,
                "attr" => array(
                    "placeholder" => "Summation",
                )
            ))
        ;
    }

    public function getYears($curYr, $diff) {
        $output = array();
        for($i = $curYr; $i>=$curYr - $diff; $i--) {
            $output[$i] = $i;
        }
        return $output;
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
