<?php

namespace Venture\PipeLineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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

            ->add('contact', null, array("mapped" => false))
            ->add('phone', null, array("mapped" => false))
            ->add('email', 'email', array("mapped" => false))
                            
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
                            
            ->add('probability', 'number', array(
                "label" => "Probability (%)",
                'attr' => array(
                    "placeholder" => "Auto calculated percentage of the selected stage"
                )))
            ->add('projected', 'number', array(
                "label" => "Projected (Annual $)",
                "attr" => array(
                    "placeholder" => "Only number",
                )))
            ->add('expectedAnnualGrowth', 'number', array(
                "label" => "Expected Annual Growth (%)",
                "attr" => array(
                    "placeholder" => "Only number",
                )))
            ->add('potential', 'number', array("label" => "Potential ($)",
                "attr" => array(
                    "placeholder" => "Only number"
                )))

            ->add('yearSales', 'collection', array(
                "type"      => new \Venture\PipeLineBundle\Form\PipeLineYearSaleType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false,
            ))

            ->add('notes', 'collection', array(
                "type"      => new \Venture\PipeLineBundle\Form\PipeLineNoteType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $pipeLine = $event->getData();
            $form = $event->getForm();

            if ($pipeLine->getId()) {
                $form->add('goal', 'number', array(
                    "label" => "Goal (Calculated)",
                    "attr" => array(
                        "placeholder" => "Only number",
                    )));
            }
        });
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
