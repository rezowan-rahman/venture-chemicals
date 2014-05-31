<?php

namespace Venture\VendorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SupplierYearType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $dateArray = array();
        for($i = date("Y"); $i >= 1977; $i--) $dateArray[$i] = $i;
        
        $resolver->setDefaults(array(
            'choices' => $dateArray
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'supplier_year';
    }
}