<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\ShippingMethod;
use Settings\ConfigBundle\Form\ShippingMethodType;

class ShippingMethodController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $methods = $em->getRepository('SettingsConfigBundle:ShippingMethod')->getLatestMethods();
        
        return $this->render('SettingsConfigBundle:ShippingMethod:index.html.twig', array(
            'methods' => $methods,
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $method = (!$id) ? new ShippingMethod() : $em->getRepository('SettingsConfigBundle:ShippingMethod')->find($id);
        
        if(!$method) throw $this->createNotFoundException('Unable to find Shipping Method');
        
        $form = $this->createForm(new ShippingMethodType(), $method);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($method);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Shipping method is added');
                else $this->get('session')->getFlashBag()->add('notice','Shipping method is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_shipping_method_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:ShippingMethod:form.html.twig', array(
            'method' => $method,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $methods = $em->getRepository('SettingsConfigBundle:ShippingMethod')->getLatestMethods();
        
        return $this->render('SettingsConfigBundle:ShippingMethod:update.html.twig', array(
            'methods' => $methods,
            'method_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $method = $em->getRepository('SettingsConfigBundle:ShippingMethod')->find($id);

        if (!$method) {
            throw $this->createNotFoundException('Unable to find shipping method.');
        }
        
        $em->remove($method);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A shipping method value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_shipping_method_list'));
        
    }
}
