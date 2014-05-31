<?php

namespace Venture\PackagingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Venture\PackagingBundle\Entity\Packaging;
use Venture\CommonBundle\Entity\ShippingDetails;

use Venture\PackagingBundle\Form\Type\PackagingType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Doctrine\Common\Collections\ArrayCollection;

class PackagingController extends Controller
{
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    } 
    
    /**
     * @Route("/list/{type}", name="venture_packaging_list")
     * @Template()
     */
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;
        $em = $this->initDoctrine();
        $packaging = $em->getRepository('VenturePackagingBundle:Packaging')->getLatestPackaging($active);
        
        return $this->render('VenturePackagingBundle:Packaging:list.html.twig', array(
            'packaging' => $packaging,
            'status' => $active
        ));
    }
    
    
    /**
     * @Route("/view/{id}", name="venture_packaging_details")
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->initDoctrine();
        $packaging = $em->getRepository('VenturePackagingBundle:Packaging')->find($id);

        if (!$packaging) {
            throw $this->createNotFoundException('Unable to find Packaging data');
        }
        
        return $this->render('VenturePackagingBundle:Packaging:details.html.twig', array(
            'packaging'         => $packaging,
            'shipping_details'  => $packaging->getShippingDetails(),
            'quoting_cost'      => $packaging->getQuotingCost(),
            'lowest_cost'       => $packaging->getLowestCost(),
            'id'                => $id,
        ));
    }
    
    /**
     * @Route("/add", name="venture_packaging_add")
     * @Template()
     */
    
    public function addAction() {
        $em = $this->initDoctrine();
                
        $packaging = new Packaging();
        
        $unitOfMeasure = $em->getRepository('SettingsConfigBundle:UnitOfMeasure')
                ->findOneBy(array("name" => "ea"));
        
        $form = $this->createForm(new PackagingType($unitOfMeasure), $packaging);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach($packaging->getShippingDetails() as $shipping) {
                    $shipping->setVenturePackaging($packaging);
                }
                
                $low = $this->calculateCost($packaging->getShippingDetails(), "min");
                $packaging->setLowestCost($low);
                
                $high = $this->calculateCost($packaging->getShippingDetails(), "max");
                $packaging->setQuotingCost($high);
                
                $em->persist($packaging);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A packaging is added');
                return $this->redirect($this->generateUrl('venture_packaging_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VenturePackagingBundle:Packaging:template.html.twig', array(
            'form' => $form->createView(),
            'action' => "add",
        ));
    }
    
    /**
     * @Route("/update/{id}", name="venture_packaging_edit")
     * @Template()
     */
    public function updateAction($id) {
        $em = $this->initDoctrine();
                        
        $packaging = $em->getRepository('VenturePackagingBundle:Packaging')->find($id);

        if (!$packaging) {
            throw $this->createNotFoundException('Unable to find packaging');
        }
        
        $originalShippingDetails = new ArrayCollection();
        
        foreach ($packaging->getShippingDetails() as $ship) {
            $originalShippingDetails->add($ship);
        }
        
        $form = $this->createForm(new PackagingType($packaging->getUnitOfMeasure()), $packaging);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach ($originalShippingDetails as $ship) {
                    if (false === $packaging->getShippingDetails()->contains($ship)) {
                        $packaging->removeShippingDetail($ship);
                        $em->remove($ship);
                    }
                }
                foreach($packaging->getShippingDetails() as $shipping) {
                    $shipping->setVenturePackaging($packaging);
                }
                
                $low = $this->calculateCost($packaging->getShippingDetails(), "min");
                $packaging->setLowestCost($low);
                
                $high = $this->calculateCost($packaging->getShippingDetails(), "max");
                $packaging->setQuotingCost($high);
                
                $em->persist($packaging);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A packaging is updated');
                return $this->redirect($this->generateUrl('venture_packaging_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VenturePackagingBundle:Packaging:template.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            "action" => "edit",
        ));
    }
    
    /**
     * @Route("/delete/{id}", name="venture_packaging_delete")
     * @Template()
     */
    public function removeAction($id) {
        $em = $this->initDoctrine();
        $packaging = $em->getRepository('VenturePackagingBundle:Packaging')->find($id);

        if (!$packaging) {
            throw $this->createNotFoundException('Unable to find packaging');
        }
        
        $em->remove($packaging);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A packaging is deleted');
        
        return $this->redirect($this->generateUrl('venture_packaging_list', array('type' => 'show_all')));
    }
    
    public function calculateCost($shippingDetails, $type = "min") {
        $res = ($type == "min") ? 99999 : 0;
        foreach($shippingDetails as $shipping) {
            if($type == "min") {
                if($shipping->getCostPerUnit() < $res) $res = $shipping->getCostPerUnit();
            } else {
                if($shipping->getCostPerUnit() > $res) $res = $shipping->getCostPerUnit();
            }
        }
        
        return $res;
    }
}
