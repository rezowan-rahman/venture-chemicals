<?php

namespace Venture\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

use Doctrine\ORM\EntityRepository;

class RegistrationFormType extends BaseType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array("label" => "Username"))
            ->add('email', "email", array("label" => "E-mail"))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Re-enter Password'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('firstName', null, array("label" => "First Name"))
            ->add('lastName', null, array("label" => "Last Name"))
            ->add('phone', null, array("label" => "Phone No"))
            ->add('location', 'entity', array(
                "class" => 'SettingsConfigBundle:Location',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('l')    
                                ->select('l')
                                ->where('l.isActive = :active')->setParameter('active', true)
                                ->orderBy('l.name', 'ASC');
                    },
                "empty_value" => "Choose a Location",
                "property" => "name",
                "label" => "Location",
                "attr" => array(
                    "class" => "location"
                )
            )) 
            
            ->add("groups", "entity", array(
                "class" => 'VentureUserBundle:Group',
                "query_builder" => function(EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->select('g')
                                ->orderBy('g.name', 'ASC');
                },
                "property" => "name",
                "label" => "Roles",
                "multiple" => true,
                "attr" => array(
                    "class" => "group"
                )
            ))              
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_user_registration';
    }
}
