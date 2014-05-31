<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductLineController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $pLines = $em->getRepository('SettingsConfigBundle:ProductLine')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:ProductLine:index.html.twig', array(
            'productLines' => $pLines,
        ));
    }
    
    public function createAction($id=false) {
        $em = $this->getDoctrine()->getManager();
        
        $pLine = (!$id) ? 
                new \Settings\ConfigBundle\Entity\ProductLine(): 
                $em->getRepository('SettingsConfigBundle:ProductLine')->find($id);
        
        if(!$pLine) throw $this->createNotFoundException('Unable to find product line');
        
        $form = $this->createForm(new \Settings\ConfigBundle\Form\ProductLineType(), $pLine);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($pLine);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Product Line is added');
                else $this->get('session')->getFlashBag()->add('notice','A Product Line is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_product_line_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:ProductLine:form.html.twig', array(
            'productLine' => $pLine,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $pLines = $em->getRepository('SettingsConfigBundle:ProductLine')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:ProductLine:update.html.twig', array(
            'productLines' => $pLines,
            'product_line_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $pLine = $em->getRepository('SettingsConfigBundle:ProductLine')->find($id);

        if (!$pLine) {
            throw $this->createNotFoundException('Unable to find Product Line');
        }
        
        $em->remove($pLine);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A product line is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_product_line_list'));
    }
}