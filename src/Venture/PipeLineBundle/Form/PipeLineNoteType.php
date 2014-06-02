<?php

namespace Venture\PipeLineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PipeLineNoteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body',"text", array("label" => "Notes"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Venture\PipeLineBundle\Entity\PipeLineNote'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'venture_pipelinebundle_pipelinenote';
    }
}
