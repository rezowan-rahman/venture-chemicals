<?php

namespace Venture\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class SalesPointCostType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salesPricePoint', 'entity', array(
                "class" => 'SettingsConfigBundle:SalesPricePoint',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('spp')    
                                ->select('spp')
                                ->where('spp.approved = :active')->setParameter('active', 1)
                                ->orderBy('spp.salesCostPoint', 'ASC');
                    },
                "empty_value" => "Select a Price Point",
                "property" => "salesCostPoint",
                "label" => "Price Point",
                "required" => false
            )) 
            ->add('cost', "text", array("required" => true, "label" => "Price"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\CommonBundle\Entity\SalesPointCost'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_commonbundle_salespointcost';
    }
}
