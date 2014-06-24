<?php

namespace Venture\AlternateRawMaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Venture\AlternateRawMaterialBundle\Entity\AlternateRawMaterial;
use Venture\AlternateRawMaterialBundle\Form\Type\AlternateRawMaterialType;
use Venture\AlternateRawMaterialBundle\Form\Type\ConvertToRawMaterialType;

use Venture\RawMaterialsBundle\Entity\RawMaterials;

use Doctrine\Common\Collections\ArrayCollection;


class AlternateRawMaterialController extends Controller
{
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    }
    
    /**
     *
     * @Route("/list/{type}", name="venture_list_alternate_raw_material")
     * @Method("GET")
     * @Template()
     */
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;

        $condition = array();
        $condition['isConvertedToRawMaterial'] = false;
        if($active) $condition["isActive"] = $active;

        $em = $this->initDoctrine();
        $alternateRawMaterials = $em
            ->getRepository('VentureAlternateRawMaterialBundle:AlternateRawMaterial')
            ->findBy($condition, array(
                "updated" => "DESC",
            ));
        
        return array(
            'alternateRawMaterials' => $alternateRawMaterials,
            'status' => $active
        );
    }
    
    
    /**
     *
     * @Route("/new", name="venture_new_alternate_raw_material")
     * @Method("GET|POST")
     * @Template()
     */
    public function addAction(Request $request) {
        $em = $this->initDoctrine();
                
        $alternateRawMaterial = new AlternateRawMaterial();
        
        $form = $this->createForm(new AlternateRawMaterialType(), $alternateRawMaterial);
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                foreach($alternateRawMaterial->getTags() as $tag) {
                    $tag->addAlternateRawMaterial($alternateRawMaterial);
                }
                foreach($alternateRawMaterial->getProperties() as $property) {
                    $property->addAlternateRawMaterial($alternateRawMaterial);
                }
                foreach($alternateRawMaterial->getOrderingDetails() as $order) {
                    $order->setAlternateRawMaterial($alternateRawMaterial);
                }
                
                $low = $this->calculateCost($alternateRawMaterial->getOrderingDetails(), "min");
                $alternateRawMaterial->setLowestCost($low);
                
                $high = $this->calculateCost($alternateRawMaterial->getOrderingDetails(), "max");
                $alternateRawMaterial->setQuotingCost($high);
                
                $em->persist($alternateRawMaterial);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','An Alternate raw materials is added');
                return $this->redirect($this->generateUrl("venture_show_alternate_raw_material", array("id" => $alternateRawMaterial->getId())));
            }
        }
        
        return array('form' => $form->createView());
    }
    
    
    /**
     *
     * @Route("/{id}/details", name="venture_show_alternate_raw_material")
     * @Method("GET")
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->initDoctrine();
        
        $alternateRawMaterial = $em->getRepository('VentureAlternateRawMaterialBundle:AlternateRawMaterial')->find($id);
        
        if(!$alternateRawMaterial || true === $alternateRawMaterial->getIsConvertedToRawMaterial()) {
            throw $this->createNotFoundException('Unable to find Alternate Raw material data');
        }
        
        return array( 'alternateRawMaterial'=> $alternateRawMaterial );
    }
    
    
    /**
     *
     * @Route("/{id}/update", name="venture_edit_alternate_raw_material")
     * @Method("GET|POST")
     * @Template()
     */
    public function updateAction(Request $request, $id) {
        $em = $this->initDoctrine();
                        
        $alternateRawMaterial = $em->getRepository('VentureAlternateRawMaterialBundle:AlternateRawMaterial')->find($id);
        
        if(!$alternateRawMaterial || true === $alternateRawMaterial->getIsConvertedToRawMaterial()) {
            throw $this->createNotFoundException('Unable to find Alternate Raw material data');
        }

        $originalTags = new ArrayCollection();
        $originalProperties = new ArrayCollection();
        $originalOrderingDetails = new ArrayCollection();

        foreach ($alternateRawMaterial->getTags() as $tag) {
            $originalTags->add($tag);
        }

        foreach ($alternateRawMaterial->getProperties() as $property) {
            $originalProperties->add($property);
        }
        
        foreach ($alternateRawMaterial->getOrderingDetails() as $order) {
            $originalOrderingDetails->add($order);
        }
        
        $form = $this->createForm(new AlternateRawMaterialType(), $alternateRawMaterial);
        $form->handleRequest($form);
        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {
                foreach ($originalTags as $tag) {
                    if (false === $alternateRawMaterial->getTags()->contains($tag)) {
                        $tag->removeAlternateRawMaterial($alternateRawMaterial);
                    }
                }

                foreach ($originalProperties as $property) {
                    if (false === $alternateRawMaterial->getProperties()->contains($property)) {
                        $property->removeAlternateRawMaterial($alternateRawMaterial);
                        $em->remove($property);
                    }
                }
                
                foreach ($originalOrderingDetails as $order) {
                    if (false === $alternateRawMaterial->getOrderingDetails()->contains($order)) {
                        $em->remove($order);
                    }
                }

                foreach($alternateRawMaterial->getTags() as $tag) {
                    if (false === $tag->getAlternateRawMaterials()->contains($alternateRawMaterial)) {
                        $tag->addAlternateRawMaterial($alternateRawMaterial);
                    }
                }
                            
                foreach($alternateRawMaterial->getProperties() as $property) {
                    if (false === $property->getAlternateRawMaterials()->contains($alternateRawMaterial)) {
                        $property->addAlternateRawMaterial($alternateRawMaterial);
                    }
                }
                
                foreach($alternateRawMaterial->getOrderingDetails() as $order) {
                    $order->setAlternateRawMaterial($alternateRawMaterial);
                }
                
                $low = $this->calculateCost($alternateRawMaterial->getOrderingDetails(), "min");
                $alternateRawMaterial->setLowestCost($low);
                
                $high = $this->calculateCost($alternateRawMaterial->getOrderingDetails(), "max");
                $alternateRawMaterial->setQuotingCost($high);
                
                $em->persist($alternateRawMaterial);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','An Alternate Raw Material is updated');
                return $this->redirect($this->generateUrl("venture_show_alternate_raw_material", array("id" => $alternateRawMaterial->getId())));
            }
        }
        
        return array(
            'form' => $form->createView(),
            'id' => $id
        );
    }
    
    /**
     *
     * @Route("/{id}/delete", name="venture_remove_alternate_raw_material")
     * @Method("GET")
     * @Template()
     */
    public function removeAction($id, $noticeAndRedirect = true) {
        $em = $this->initDoctrine();
        $alternateRawMaterial = $em->getRepository('VentureAlternateRawMaterialBundle:AlternateRawMaterial')->find($id);
        
        if(!$alternateRawMaterial || true === $alternateRawMaterial->getIsConvertedToRawMaterial()) {
            throw $this->createNotFoundException('Unable to find Alternate Raw material data');
        }
        
        $em->remove($alternateRawMaterial);
        $em->flush();
        
        if(!$noticeAndRedirect) return true; 
        
        $this->get('session')->getFlashBag()->add('notice','An Alternate raw material is deleted');
        
        return $this->redirect($this->generateUrl("venture_new_alternate_raw_material"));
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
    
    
    /**
     *
     * @Route("/{id}/convert/raw-materials", name="venture_convert_alternate_raw_material")
     * @Method("GET|POST")
     * @Template()
     */
    public function convertToRawMaterialsAction(Request $request, $id) {
        $em = $this->initDoctrine();
        $alternateRawMaterial = $em->getRepository('VentureAlternateRawMaterialBundle:AlternateRawMaterial')->find($id);
        
        if(!$alternateRawMaterial || true === $alternateRawMaterial->getIsConvertedToRawMaterial()) {
            throw $this->createNotFoundException('Unable to find Alternate Raw material data');
        }

        $form = $this->createForm(new ConvertToRawMaterialType, 
            $alternateRawMaterial, 
            array(
                "action" => $this->generateUrl('venture_convert_alternate_raw_material', array('id' => $id)),
                "method" => 'POST',
            ));
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST') {
            /*convert into raw materials */

            $rawMaterial = new RawMaterials();

            $rawMaterial->setItemNumber($form->get('itemNumber')->getData());
            $rawMaterial->setReorderPoint($form->get('reorderPoint')->getData());


            $rawMaterial->setItemName($alternateRawMaterial->getItemName());
            $rawMaterial->setDescription($alternateRawMaterial->getItemDescription());
            $rawMaterial->setUnitOfMeasure($alternateRawMaterial->getUnitOfMeasure());
            $rawMaterial->setQuotingCost($alternateRawMaterial->getQuotingCost());
            $rawMaterial->setLowestCost($alternateRawMaterial->getLowestCost());
            $rawMaterial->setIsActive($alternateRawMaterial->getIsActive());

            foreach($alternateRawMaterial->getTags() as $tag) {
                $tag->removeAlternateRawMaterial($alternateRawMaterial);
                if (false === $tag->getRawMaterials()->contains($rawMaterial)) {
                    $tag->addRawMaterial($rawMaterial);
                }
            }

            foreach($alternateRawMaterial->getProperties() as $property) {
                $property->removeAlternateRawMaterial($alternateRawMaterial);
                if (false === $property->getRawMaterials()->contains($rawMaterial)) {
                    $property->addRawMaterial($rawMaterial);
                }
            }
        
            foreach($alternateRawMaterial->getOrderingDetails() as $order) {
                $order->setRawMaterial($rawMaterial);
                $order->setAlternateRawMaterial($alternateRawMaterial);
            }
            
            $alternateRawMaterial->setIsConvertedToRawMaterial(true);
            $em->persist($alternateRawMaterial);
            $em->persist($rawMaterial);
            $em->flush();


            $this->get('session')
                ->getFlashBag()
                ->add('notice','Item successfully converted to Raw Materials');

            return $this->redirect(
                $this->generateUrl(
                    "venture_raw_materials_edit", 
                    array("id" => $rawMaterial->getId())
                ));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
