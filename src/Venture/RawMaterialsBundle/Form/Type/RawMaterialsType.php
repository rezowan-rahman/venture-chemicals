<?php

namespace Venture\RawMaterialsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class RawMaterialsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item_number', 'text', array("label" => "Item Number"))
            ->add('item_name', 'text', array("label" => "Item Name"))
            ->add('description', 'text', array("label" => "Description"))
            ->add('unit_of_measure', 'entity', array(
                "class" => 'SettingsConfigBundle:UnitOfMeasure',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')    
                                ->select('u')
                                ->where('u.approved = :active')->setParameter('active', 1)
                                ->orderBy('u.name', 'ASC');
                    },
                "empty_value" => "Choose a Unit",
                "property" => "name",
                "label" => "Unit of Measure"
            ))
            ->add('tags', 'tag', array("label" => "Tags/Keywords", "required" => false))
            ->add('specs', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\PropertyType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('shipping_details', 'collection', array(
                "type"      => new \Venture\CommonBundle\Form\Type\ShippingDetailsType(),
                "allow_add" => true,
                'allow_delete' => true,
                "by_reference" => false,
                "label" => false
            )) 
            ->add('reorder_point', 'text', array("label" => "Re-Order Point", "required" => false))
            ->add('is_active', 'checkbox', array("label" => "Active", "required" => false))
            ->add('alternateRawMaterials','entity', array(
                    'class' => 'VentureAlternateRawMaterialBundle:AlternateRawMaterial',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('arm')
                                ->select('arm')
                                ->where('arm.isActive = :active')->setParameter('active', true)
                                ->andWhere('arm.isConvertedToRawMaterial = :converted')->setParameter("converted", false)
                                ->orderBy('arm.itemName', 'ASC');
                    },
                    'property' => 'itemName',
                    "label" => "Possible Alternatives",
                    'multiple'  => true,
                    'required' => false,
                    "attr" => array('class' => 'selectBoxWidthFix heightFix')
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\RawMaterialsBundle\Entity\RawMaterials'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rawmaterials';
    }
}