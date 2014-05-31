<?php

namespace Venture\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\GroupFormType as BaseType;

use Symfony\Component\DependencyInjection\ContainerInterface;


class GroupFormType extends BaseType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array(
            'label' => 'Name', 
            'translation_domain' => 'FOSUserBundle',
            "attr" => array(
                "class" => "group_name"
            )))
            
            ->add('description', "textarea", array(
                'label' => 'Description', 
                "attr" => array(
                    "class" => "group_desc"
                )))
            
            /*
            ->add("roles", "choice", array(
                "multiple" => true,
                'choices'  => array(
                    "ROLE_ADMIN" => "ROLE_ADMIN",
                    "ROLE_USER" => "ROLE_USER",
                ), 
                "attr" => array(
                    "class" => "group_role"
                )))*/
            ;
    }
    
    public function getName()
    {
        return 'venture_user_group';
    }
}