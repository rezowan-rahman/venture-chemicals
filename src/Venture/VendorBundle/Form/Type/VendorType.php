<?php

namespace Venture\VendorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class VendorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array("label" => "Vendor Name"))
            ->add('supplier_since', new SupplierYearType(), array(
                'empty_value' => 'Choose a year',
                'label' => 'Supplier Since',
                "attr" => array('class' => 'selectBoxWidthFix')
            ))
            ->add('street_1',null, array("label" => "Street Address Line 1"))
            ->add('street_2', null, array("label" => "Street Address Line 2", "required" => false))
            ->add('city')
            ->add('state', new StateType(), array(
                'empty_value' => 'Choose a state',
                "attr" => array('class' => 'selectBoxWidthFix')
            ))
            ->add('zip_code',null, array("label" => "Zip Code"))
            ->add('website')
            ->add('phone',null, array("label" => "Phone Number"))
            ->add('contact_1')
            ->add('contact_1_email',null, array("label" => "Contact 1 Email Address"))
            ->add('contact_2', null, array("required" => false))
            ->add('contact_2_email', null, array("label" => "Contact 2 Email Address", "required" => false))  
            ->add('children','entity', array(
                    'class' => 'VentureVendorBundle:Vendor',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('v')
                                ->select('v')
                                ->where('v.active = :active')->setParameter('active', 1)
                                ->orderBy('v.name', 'ASC');
                    },
                    'empty_value' => 'Choose a Vendor',
                    'property' => 'name',
                    "label" => "Affiliated Companies",
                    'multiple'  => true,
                    'required' => false,
                    "attr" => array('class' => 'selectBoxWidthFix heightFix')
                ))
            ->add('active', null, array("required" => false))
            ->add('note', 'textarea', array(
                "label" => "Notes Section",
                "required" => false,
                "attr" => array('class' => 'textAreaWidthFix')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\VendorBundle\Entity\Vendor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_vendorbundle_vendor';
    }
}
