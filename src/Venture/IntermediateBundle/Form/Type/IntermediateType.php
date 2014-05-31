<?php

namespace Venture\IntermediateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class IntermediateType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemNumber', 'text', array("label" => "Item Number", "required" => true))
            ->add('itemName', 'text', array("label" => "Item Name", "required" => true))
            ->add('itemDescription', 'text', array("label" => "Description", "required" => true))
            ->add('reasonForChange', 'text', array("label" => "Reason for Change", "required" => true))
            ->add('tags', 'text', array("label" => "Tags, Keywords: Seperate by Comma", "required" => true)) 
            ->add('isActive', 'checkbox', array("label" => "Active", "required" => false))
            ->add('unitOfMeasure', 'entity', array(
                "class" => 'SettingsConfigBundle:UnitOfMeasure',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('um')    
                                ->select('um')
                                ->where('um.approved = :active')->setParameter('active', 1)
                                ->orderBy('um.name', 'ASC');
                    },
                "empty_value" => "Choose a Unit",
                "property" => "name",
                "label" => "Unit Of Measure",
                "required" => true
            ))
            ->add('properties', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\PropertyType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('formulas', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\FormulaType(),
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
            'data_class' => 'Venture\IntermediateBundle\Entity\Intermediate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_intermediatebundle_intermediate';
    }
}
