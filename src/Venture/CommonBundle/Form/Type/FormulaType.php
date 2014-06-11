<?php

namespace Venture\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class FormulaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rawMaterial', 'entity', array(
                "class" => 'VentureRawMaterialsBundle:RawMaterials',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('rm')    
                                ->select('rm')
                                ->where('rm.is_active = :active')->setParameter('active', 1)
                                ->orderBy('rm.item_name', 'ASC');
                    },
                "empty_value" => "Choose Ingredient",
                "property" => "item_name",
                "label" => "Formulation(Raw Material)",
                "required" => false
            )) 
            ->add('ingredient', 'entity', array(
                "class" => 'VentureIntermediateBundle:Intermediate',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('i')    
                                ->select('i')
                                ->where('i.isActive = :active')->setParameter('active', 1)
                                ->orderBy('i.itemName', 'ASC');
                    },
                "empty_value" => "Choose Ingredient",
                "property" => "itemName",
                "label" => "Formulation(Intermediate)",
                "required" => false
            )) 
            ->add('amount', "text", array("label" => "Amount" , "required" => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\CommonBundle\Entity\Formula'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_commonbundle_formula';
    }
}
