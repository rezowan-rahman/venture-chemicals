<?php
/**
 * Created by PhpStorm.
 * User: rezowan
 * Date: 6/17/14
 * Time: 10:50 AM
 */

namespace Venture\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Venture\CommonBundle\Form\DataTransformer\TagsToStringTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TagsToStringTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The tags entered is not valid',
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'tag';
    }
}