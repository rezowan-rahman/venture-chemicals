<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('SettingsConfigBundle:Location')->getLatestLocations();
        
        return $this->render('SettingsConfigBundle:Location:index.html.twig', array(
            'locations' => $locations,
        ));
    }
    
    public function createAction($id=false) {
        $em = $this->getDoctrine()->getManager();
        
        $location = (!$id) ? 
                new \Settings\ConfigBundle\Entity\Location(): 
                $em->getRepository('SettingsConfigBundle:Location')->find($id);
        
        if(!$location) throw $this->createNotFoundException('Unable to find location');
        
        $form = $this->createForm(new \Settings\ConfigBundle\Form\LocationType(), $location);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($location);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Location is added');
                else $this->get('session')->getFlashBag()->add('notice','A Location is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_location_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Location:form.html.twig', array(
            'location' => $location,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('SettingsConfigBundle:Location')->getLatestLocations();
        
        return $this->render('SettingsConfigBundle:Location:update.html.twig', array(
            'locations' => $locations,
            'location_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $location = $em->getRepository('SettingsConfigBundle:Location')->find($id);

        if (!$location) {
            throw $this->createNotFoundException('Unable to find location');
        }
        
        $em->remove($location);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A location is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_location_list'));
    }
}