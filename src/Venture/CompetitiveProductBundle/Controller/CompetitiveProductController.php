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

        $condition = array();
        if($active) $condition["isActive"] = $active;

        $em = $this->initDoctrine();
        $competitiveProducts = $em
            ->getRepository('VentureCompetitiveProductBundle:CompetitiveProduct')
            ->findBy($condition, array(
                "updated" => "DESC"
            ));
        
        return array(
            'competitiveProducts' => $competitiveProducts,
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
    public function addAction() {
        $em = $this->initDoctrine();
                
        $competitiveProduct = new CompetitiveProduct();
        
        $form = $this->createForm(new CompetitiveProductType(), $competitiveProduct);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach($competitiveProduct->getProperties() as $prop) {
                    $prop->setCompetitiveProduct($competitiveProduct);
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
        
        $originalProperties     = new ArrayCollection();
        
        foreach ($competitiveProduct->getProperties() as $property) {
            $originalProperties->add($property);
        }
        
        $form = $this->createForm(new CompetitiveProductType(), $competitiveProduct);

        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($originalProperties as $property) {
                if (false === $competitiveProduct->getProperties()->contains($property)) {
                    $em->remove($property);
                }
            }
            
            foreach($competitiveProduct->getProperties() as $prop) {
                    $prop->setCompetitiveProduct($competitiveProduct);
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
