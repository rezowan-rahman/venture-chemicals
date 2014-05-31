<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\TestProcedure;
use Settings\ConfigBundle\Form\TestProcedureType;

class TestProcedureController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $procedures = $em->getRepository('SettingsConfigBundle:TestProcedure')->getLatestProcedures();
        
        return $this->render('SettingsConfigBundle:TestProcedure:index.html.twig', array(
            'procedures' => $procedures,
            'id' => 0
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $procedure = (!$id) ? new TestProcedure() : $em->getRepository('SettingsConfigBundle:TestProcedure')->find($id);
        
        if(!$procedure) throw $this->createNotFoundException('Unable to find test procedure.');
        
        $form = $this->createForm(new TestProcedureType(), $procedure);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $procedure->upload();
                $em->persist($procedure);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A procedure value is added');
                else $this->get('session')->getFlashBag()->add('notice','procedure value is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_test_procedure_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:TestProcedure:form.html.twig', array(
            'procedure' => $procedure,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $procedures = $em->getRepository('SettingsConfigBundle:TestProcedure')->getLatestProcedures();
        
        return $this->render('SettingsConfigBundle:TestProcedure:update.html.twig', array(
            'procedures' => $procedures,
            'procedure_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $procedure = $em->getRepository('SettingsConfigBundle:TestProcedure')->find($id);

        if (!$procedure) {
            throw $this->createNotFoundException('Unable to find test procedure.');
        }
        
        $em->remove($procedure);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A test procedure value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_test_procedure_list'));
        
    }
}
