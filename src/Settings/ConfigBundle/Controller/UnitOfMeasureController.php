<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\UnitOfMeasure;
use Settings\ConfigBundle\Form\UnitOfMeasureType;

class UnitOfMeasureController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $units = $em->getRepository('SettingsConfigBundle:UnitOfMeasure')->getLatestUnits();
        
        return $this->render('SettingsConfigBundle:UnitOfMeasure:index.html.twig', array(
            'units' => $units,
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $unit = (!$id) ? new UnitOfMeasure() : $em->getRepository('SettingsConfigBundle:UnitOfMeasure')->find($id);
        
        if(!$unit) throw $this->createNotFoundException('Unable to find Unit');
        
        $form = $this->createForm(new UnitOfMeasureType(), $unit);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($unit);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A unit value is added');
                else $this->get('session')->getFlashBag()->add('notice','unit value is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_unit_of_measure_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:UnitOfMeasure:form.html.twig', array(
            'unit' => $unit,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $units = $em->getRepository('SettingsConfigBundle:UnitOfMeasure')->getLatestUnits();
        
        return $this->render('SettingsConfigBundle:UnitOfMeasure:update.html.twig', array(
            'units' => $units,
            'unit_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $unit = $em->getRepository('SettingsConfigBundle:UnitOfMeasure')->find($id);

        if (!$unit) {
            throw $this->createNotFoundException('Unable to find unit.');
        }
        
        $em->remove($unit);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A unit value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_unit_of_measure_list'));
        
    }
}
