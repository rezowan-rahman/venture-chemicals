<?php

namespace Venture\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class PropertyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', 'entity', array(
                "class" => 'SettingsConfigBundle:Property',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')    
                                ->select('p')
                                ->where('p.approved = :active')->setParameter('active', 1)
                                ->orderBy('p.name', 'ASC');
                    },
                "empty_value" => "Choose a Property",
                "property" => "name",
                "label" => "Properties",
                "required" => false
            )) 
            ->add('specificationMath', "text", array("label" => "Specification Math" , "required" => false))
            ->add('specification', "text", array("label" => "Specification", "required" => false))
            ->add('testProcedure', 'entity', array(
                "class" => 'SettingsConfigBundle:TestProcedure',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('tp')    
                                ->select('tp')
                                ->where('tp.approved = :active')->setParameter('active', 1)
                                ->orderBy('tp.name', 'ASC');
                    },
                "empty_value" => "Choose a test procedure",
                "property" => "name",
                "label" => "Test Procedure",
                "required" => false
            )) 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\CommonBundle\Entity\Property'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_commonbundle_property';
    }
}
