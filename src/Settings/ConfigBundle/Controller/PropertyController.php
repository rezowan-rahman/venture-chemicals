<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\Property;
use Settings\ConfigBundle\Form\PropertyType;

class PropertyController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $properties = $em->getRepository('SettingsConfigBundle:Property')->getLatestProperties();
        
        return $this->render('SettingsConfigBundle:Property:index.html.twig', array(
            'properties' => $properties,
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $property = (!$id) ? new Property() : $em->getRepository('SettingsConfigBundle:Property')->find($id);
        
        if(!$property) throw $this->createNotFoundException('Unable to find property.');
        
        $form = $this->createForm(new PropertyType(), $property);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($property);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A property value is added');
                else $this->get('session')->getFlashBag()->add('notice','property value is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_property_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Property:form.html.twig', array(
            'property' => $property,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $properties = $em->getRepository('SettingsConfigBundle:Property')->getLatestProperties();
        
        return $this->render('SettingsConfigBundle:Property:update.html.twig', array(
            'properties' => $properties,
            'property_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $property = $em->getRepository('SettingsConfigBundle:Property')->find($id);

        if (!$property) {
            throw $this->createNotFoundException('Unable to find property.');
        }
        
        $em->remove($property);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A property value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_property_list'));
        
    }
}
