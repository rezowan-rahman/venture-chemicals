<?php

namespace Venture\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class UpdateUserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                "label" => "Username", "attr" => array(
                    "class" => "user-input"
                )))
            ->add('email', "email", array(
                "label" => "E-mail", "attr" => array(
                    "class" => "user-input"
                )))
            ->add('firstName', null, array(
                "label" => "First Name", "attr" => array(
                    "class" => "user-input"
                )))
            ->add('lastName', null, array(
                "label" => "Last Name", "attr" => array(
                    "class" => "user-input"
                )))
            ->add('phone', null, array(
                "label" => "Phone No", "attr" => array(
                    "class" => "user-input"
                )))
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_userbundle_updateuser';
    }
}
