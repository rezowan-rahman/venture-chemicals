<?php

namespace Venture\CompetitiveProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Venture\CompetitiveProductBundle\Entity\CompetitiveProduct;
use Venture\CompetitiveProductBundle\Form\Type\CompetitiveProductType;

use Doctrine\Common\Collections\ArrayCollection;

class CompetitiveProductController extends Controller
{
    
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    } 
    
    /**
     * @Route("/list/{type}", name="venture_competitive_product_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;
        $em = $this->initDoctrine();

        $competitiveProducts = $em
            ->getRepository('VentureCompetitiveProductBundle:CompetitiveProduct')
            ->getLatestProducts($active);

        $pagination = $this->get('knp_paginator')->paginate(
            $competitiveProducts,
            $this->get('request')->query->get('page', 1),
            5
        );
        
        return array(
            'pagination' => $pagination,
            'status' => $active
        );
    }

    /**
     * @Route("/{id}/details", name="venture_competitive_product_view")
     * @Method("GET")
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->initDoctrine();
        $competitiveProduct = $em->getRepository('VentureCompetitiveProductBundle:CompetitiveProduct')->find($id);
        
        if (!$competitiveProduct) throw $this->createNotFoundException('Unable to find Product data');
        
        return array(
            'competitiveProduct'    => $competitiveProduct,
            'properties'            => $competitiveProduct->getProperties(),
            'id'                    => $id,
        );
    }
    
    /**
     * @Route("/add", name="venture_competitive_product_add")
     * @Method("GET|POST")
     * @Template()
     */
    public function addAction(Request $request) {
        $em = $this->initDoctrine();
                
        $competitiveProduct = new CompetitiveProduct();
        
        $form = $this->createForm(new CompetitiveProductType(), $competitiveProduct);
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                foreach($competitiveProduct->getTags() as $tag) {
                    $tag->addCompetitiveProduct($competitiveProduct);
                }
                foreach($competitiveProduct->getProperties() as $prop) {
                    $prop->addCompetitiveProduct($competitiveProduct);
                }
                
                $em->persist($competitiveProduct);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A Competitive Product is added');
                return $this->redirect($this->generateUrl('venture_competitive_product_list', array('type' => 'show_all')));
            }
        }
        
        return array("form" => $form->createView());
    }
    
    
    /**
     * @Route("/{id}/update", name="venture_competitive_product_update")
     * @Method("GET|POST")
     * @Template()
     */
    
    public function editAction($id, Request $request) {
        $em = $this->initDoctrine();
        
        $competitiveProduct = $em->getRepository('VentureCompetitiveProductBundle:CompetitiveProduct')->find($id);
        if (!$competitiveProduct) throw $this->createNotFoundException('Unable to find Product data');

        $originalTags     = new ArrayCollection();
        $originalProperties     = new ArrayCollection();

        foreach ($competitiveProduct->getTags() as $tag) {
            $originalTags->add($tag);
        }

        foreach ($competitiveProduct->getProperties() as $property) {
            $originalProperties->add($property);
        }
        
        $form = $this->createForm(new CompetitiveProductType(), $competitiveProduct);

        $form->handleRequest($request);

        if ($form->isValid()) {

            foreach ($originalTags as $tag) {
                if (false === $competitiveProduct->getTags()->contains($tag)) {
                    $tag->removeCompetitiveProduct($competitiveProduct);
                }
            }

            foreach ($originalProperties as $property) {
                if (false === $competitiveProduct->getProperties()->contains($property)) {
                    $property->removeCompetitiveProduct($competitiveProduct);
                    $em->remove($property);
                }
            }

            foreach($competitiveProduct->getTags() as $tag) {
                if (false === $tag->getCompetitiveProducts()->contains($competitiveProduct)) {
                    $tag->addCompetitiveProduct($competitiveProduct);
                }
            }

            foreach($competitiveProduct->getProperties() as $prop) {
                if (false === $prop->getCompetitiveProducts()->contains($competitiveProduct)) {
                    $prop->addCompetitiveProduct($competitiveProduct);
                }
            }
            
            $em->persist($competitiveProduct);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice','A Competitive Product is Updated');
            return $this->redirect($this->generateUrl('venture_competitive_product_list', array('type' => 'show_all')));
        }

        return array(
            'form' => $form->createView(),
            'id' => $id
        );
    }
    
    
    /**
     * @Route("/{id}/remove", name="venture_competitive_product_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($id) {
        $em = $this->initDoctrine();
        $competitiveProduct = $em->getRepository('VentureCompetitiveProductBundle:CompetitiveProduct')->find($id);

        if (!$competitiveProduct) throw $this->createNotFoundException('Unable to find Product data');
        
        $em->remove($competitiveProduct);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Product Is Deleted');
        
        return $this->redirect($this->generateUrl('venture_competitive_product_list', array('type' => 'show_all')));
    }
}
