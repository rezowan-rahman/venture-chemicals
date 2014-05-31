<?php

namespace Venture\CustomerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Venture\CustomerBundle\Form\Type\StateType;

use Doctrine\ORM\EntityRepository;

class CustomerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array("label" => "Customer Name"))
            ->add('streetAddress1', null, array("label" => "Street Address Line 1"))
            ->add('streetAddress2', null, array("label" => "Street Address Line 2"))
            ->add('city', null, array("label" => "City"))
            ->add('state', new StateType(), array(
                'empty_value' => 'Choose a state',
                "attr" => array('class' => 'selectBoxWidthFix')
            ))
            ->add('zipCode', null, array("label" => "Zip Code"))
            ->add('website', null, array("label" => "Website"))
            ->add('phoneNumber', null, array("label" => "Phone Number"))
            ->add('contact1', null, array("label" => "Contact 1"))
            ->add('contact2', null, array("label" => "Contact 2", "required" => false))
            ->add('contact1Email', null, array("label" => "Contact 1 Email Address"))
            ->add('contact2Email', null, array("label" => "Contact 2 Email Address", "required" => false))
            ->add('isActive', null, array("label" => "Active", "required" => false)) 
            ->add('children','entity', array(
                    'class' => 'VentureCustomerBundle:Customer',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->select('c')
                                ->where('c.isActive = :active')->setParameter('active', 1)
                                ->orderBy('c.name', 'ASC');
                    },
                    'property' => 'name',
                    "label" => "Affiliated Customers",
                    'multiple'  => true,
                    'required' => false,
                    "attr" => array('class' => 'selectBoxWidthFix heightFix')
                ))
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
            'data_class' => 'Venture\CustomerBundle\Entity\Customer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_customerbundle_customer';
    }
}
