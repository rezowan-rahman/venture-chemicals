<?php

namespace Venture\RawMaterialsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Venture\RawMaterialsBundle\Entity\RawMaterials;
use Venture\CommonBundle\Entity\Property;
use Venture\RawMaterialsBundle\Entity\ShippingDetails;

use Venture\RawMaterialsBundle\Form\Type\RawMaterialsType;

use Doctrine\Common\Collections\ArrayCollection;



class RawMaterialsController extends Controller
{
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    } 
    
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;

        $em = $this->initDoctrine();

        $raw_materials = $em
            ->getRepository('VentureRawMaterialsBundle:RawMaterials')
            ->getLatestRawMaterials($active);

        $pagination = $this->get('knp_paginator')->paginate(
            $raw_materials,
            $this->get('request')->query->get('page', 1),
            5
        );
        
        return $this->render('VentureRawMaterialsBundle:RawMaterials:list.html.twig', array(
            'pagination' => $pagination,
            'status' => $active
        ));
    }


    public function viewAction($itemNumber) {
        $em = $this->initDoctrine();
        $raw_material = $em
            ->getRepository('VentureRawMaterialsBundle:RawMaterials')
            ->findOneBy(array('item_number' => $itemNumber));

        if (!$raw_material) {
            throw $this->createNotFoundException('Unable to find Raw material data');
        }
        
        return $this->render('VentureRawMaterialsBundle:RawMaterials:details.html.twig', array(
            'raw_material'      => $raw_material,
            'properties'        => $raw_material->getSpecs(),
            'shipping_details'  => $raw_material->getShippingDetails(),
            'quoting_cost'      => $raw_material->getQuotingCost(),
            'lowest_cost'       => $raw_material->getLowestCost(),
        ));
    }
    
    public function addAction(\Symfony\Component\HttpFoundation\Request $request) {
        $em = $this->initDoctrine();
                
        $raw_materials = new RawMaterials();
        
        $form = $this->createForm(new RawMaterialsType(), $raw_materials);

        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                foreach($raw_materials->getTags() as $tag) {
                    $tag->addRawMaterial($raw_materials);
                }
                foreach($raw_materials->getSpecs() as $spec) {
                    $spec->addRawMaterial($raw_materials);
                }
                foreach($raw_materials->getShippingDetails() as $shipping) {
                    $shipping->setRawMaterial($raw_materials);
                }
                
                $low = $this->calculateCost($raw_materials->getShippingDetails(), "min");
                $raw_materials->setLowestCost($low);
                
                $high = $this->calculateCost($raw_materials->getShippingDetails(), "max");
                $raw_materials->setQuotingCost($high);
                
                $em->persist($raw_materials);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A raw materials is added');
                return $this->redirect($this->generateUrl('venture_raw_materials_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VentureRawMaterialsBundle:RawMaterials:template.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function updateAction(\Symfony\Component\HttpFoundation\Request $request, $itemNumber) {
        $em = $this->initDoctrine();
                        
        $raw_materials = $em
            ->getRepository('VentureRawMaterialsBundle:RawMaterials')
            ->findOneBy(array('item_number' => $itemNumber));
        
        if(!$raw_materials) {
            throw $this->createNotFoundException('Unable to find Raw material data');
        }

        $originalTags = new ArrayCollection();
        $originalSpecs = new ArrayCollection();
        $originalShippingDetails = new ArrayCollection();
        $originalAlternateRawMaterials = new ArrayCollection();

        foreach ($raw_materials->getTags() as $tag) {
            $originalTags->add($tag);
        }

        foreach ($raw_materials->getSpecs() as $sppec) {
            $originalSpecs->add($sppec);
        }
        
        foreach ($raw_materials->getShippingDetails() as $ship) {
            $originalShippingDetails->add($ship);
        }

        foreach ($raw_materials->getAlternateRawMaterials() as $alternateRawMaterial) {
            $originalAlternateRawMaterials->add($alternateRawMaterial);
        }

        $form = $this->createForm(new RawMaterialsType(), $raw_materials);
        $form->handleRequest($request);

        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                foreach ($originalTags as $tag) {
                    if (false === $raw_materials->getTags()->contains($tag)) {
                        $tag->removeRawMaterial($raw_materials);
                    }
                }

                foreach ($originalSpecs as $sppec) {
                    if (false === $raw_materials->getSpecs()->contains($sppec)) {
                        $sppec->removeRawMaterial($raw_materials);
                        $em->remove($sppec);
                    }
                }
            
                foreach ($originalShippingDetails as $ship) {
                    if (false === $raw_materials->getShippingDetails()->contains($ship)) {
                        $em->remove($ship);
                    }
                }

                foreach ($originalAlternateRawMaterials as $alternateRawMaterial) {
                    if(false === $raw_materials->getAlternateRawMaterials()->contains($alternateRawMaterial)) {
                        $em->remove($alternateRawMaterial);
                    }
                }

                foreach($raw_materials->getTags() as $tag) {
                    if (false === $tag->getRawMaterials()->contains($raw_materials)) {
                        $tag->addRawMaterial($raw_materials);
                    }
                }
            
                foreach($raw_materials->getSpecs() as $spec) {
                    if (false === $spec->getRawMaterials()->contains($raw_materials)) {
                        $spec->addRawMaterial($raw_materials);
                    }
                }

                foreach($raw_materials->getShippingDetails() as $shipping) {
                    $shipping->setRawMaterial($raw_materials);
                }

                foreach ($raw_materials->getAlternateRawMaterials() as $alternateRawMaterial) {
                    $alternateRawMaterial->addRawMaterial($raw_materials);
                }
                
                $low = $this->calculateCost($raw_materials->getShippingDetails(), "min");
                $raw_materials->setLowestCost($low);
                
                $high = $this->calculateCost($raw_materials->getShippingDetails(), "max");
                $raw_materials->setQuotingCost($high);
                
                $em->persist($raw_materials);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A raw materials is updated');
                return $this->redirect($this->generateUrl('venture_raw_materials_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VentureRawMaterialsBundle:RawMaterials:template.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function removeAction($itemNumber) {
        $em = $this->initDoctrine();

        $raw_material = $em
            ->getRepository('VentureRawMaterialsBundle:RawMaterials')
            ->findOneBy(array('item_number' => $itemNumber));

        if (!$raw_material) {
            throw $this->createNotFoundException('Unable to find raw material');
        }
        
        $em->remove($raw_material);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A raw material is deleted');
        
        return $this->redirect($this->generateUrl('venture_raw_materials_list', array('type' => 'show_all')));
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
