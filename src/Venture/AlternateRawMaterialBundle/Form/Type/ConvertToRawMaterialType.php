<?php

namespace Venture\AlternateRawMaterialBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class ConvertToRawMaterialType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemNumber', 'text', array("label" => "Item Number", "mapped" => false, "required" => true))
            ->add('reorderPoint', 'text', array("label" => "Reorder Point", "mapped" => false, "required" => true))
            ->add('convert', 'submit', array("attr" => array("class" => "add-new")))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_alternaterawmaterialbundle_converttorawmaterial';
    }
}
