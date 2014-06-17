<?php
/**
 * Created by PhpStorm.
 * User: rezowan
 * Date: 6/17/14
 * Time: 10:53 AM
 */

namespace Venture\CommonBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

use Venture\CommonBundle\Entity\Tag;

class TagsToStringTransformer implements DataTransformerInterface
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

    public function transform($tags)
    {
        if(!count($tags) || null === $tags) return "";

        $tagArray = array();

        foreach($tags as $tag) {
            $tagArray[] = $tag->getName();
        }

        return $string = implode(',', $tagArray);
    }

    public function reverseTransform($string)
    {
        if (!$string) return null;

        $string = preg_replace('/, /', ',', $string);
        $array = explode(',', $string);

        $tags = new \Doctrine\Common\Collections\ArrayCollection();

        foreach($array as $value) {
            $tag = $this->om
                ->getRepository('VentureCommonBundle:Tag')
                ->findOneBy(array('name' => $value));

            if (null === $tag) {
                $tag = new Tag();
                $tag->setName($value);
            }

            $tags->add($tag);
        }

        return $tags;
    }
}