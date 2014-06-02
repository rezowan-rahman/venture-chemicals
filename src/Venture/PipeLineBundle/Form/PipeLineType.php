<?php

namespace Venture\PipeLineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class PipeLineType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', 'entity', array(
                "class" => 'VentureCustomerBundle:Customer',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')    
                                ->select('c')
                                ->where('c.isActive = :active')->setParameter('active', true)
                                ->orderBy('c.name', 'ASC');
                    },
                "empty_value" => "Choose a Customer",
                "property" => "name",
                "label" => "Customer Name",
            )) 
                            
            ->add('type', 'entity', array(
                "class" => 'SettingsConfigBundle:Pipelinetype',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')    
                                ->select('t')
                                ->where('t.isActive = :active')->setParameter('active', true)
                                ->orderBy('t.name', 'ASC');
                    },
                "empty_value" => "Choose a Type",
                "property" => "name",
                "label" => "Type"
            )) 
                            
            ->add('productLine', 'entity', array(
                "class" => 'SettingsConfigBundle:ProductLine',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('pl')    
                                ->select('pl')
                                ->where('pl.isActive = :active')->setParameter('active', true)
                                ->orderBy('pl.name', 'ASC');
                    },
                "empty_value" => "Choose a Product Line",
                "property" => "name",
                "label" => "Product Line"
            )) 
                            
            ->add('salesRep', 'entity', array(
                "class" => 'SettingsConfigBundle:Salesrep',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('sr')    
                                ->select('sr')
                                ->where('sr.isActive = :active')->setParameter('active', true)
                                ->orderBy('sr.name', 'ASC');
                    },
                "empty_value" => "Choose a Sales rep",
                "property" => "name",
                "label" => "Sales Rep"
            ))                 

            ->add('contact', null, array(
                "mapped" => false, 
                "attr" => array(
                    "readonly" => true, 
                    "id" =>"customer_contact")
                ))
                            
            ->add('phone', null, array(
                "mapped" => false, 
                "attr" => array(
                    "readonly" => true, 
                    "id" =>"customer_phone")
                ))
            
            ->add('email', 'email', array(
                "mapped" => false, 
                "attr" => array(
                    "readonly" => true, 
                    "id" =>"customer_email")
                ))

                            
            ->add('stage', 'entity', array(
                "class" => 'SettingsConfigBundle:Stage',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')    
                                ->select('s')
                                ->where('s.isActive = :active')->setParameter('active', true)
                                ->orderBy('s.name', 'ASC');
                    },
                "empty_value" => "Choose a Stage",
                "property" => "name",
                "label" => "Stage"
            ))                
                            
            ->add('probability', null, array(
                "label" => "Probability (%)",
                'attr' => array(
                    "readonly" => true,
                )))
            ->add('projected', null, array("label" => "Projected (Annual $)"))
            ->add('expectedAnnualGrowth', null, array("label" => "Expected Annual Growth (%)"))
            ->add('potential', null, array("label" => "Potential ($)"))

            ->add('yearSales', 'collection', array(
                "type"      => new \Venture\PipeLineBundle\Form\PipeLineYearSaleType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            ))
        ;
    }


    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\PipeLineBundle\Entity\PipeLine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_pipelinebundle_pipeline';
    }
}
