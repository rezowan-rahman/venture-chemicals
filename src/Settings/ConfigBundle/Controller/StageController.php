<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StageController
 *
 * @author mhabub
 */
namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StageController extends Controller{
  public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $allStages = $em->getRepository('SettingsConfigBundle:Stage')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Stage:index.html.twig', array(
            'stages' => $allStages,
        ));
    }
    
    public function createAction($id=false) {
        $em = $this->getDoctrine()->getManager();
        
        $stage = (!$id) ? 
                new \Settings\ConfigBundle\Entity\Stage(): 
                $em->getRepository('SettingsConfigBundle:Stage')->find($id);
        
        if(!$stage) throw $this->createNotFoundException('Unable to find Stage');
        
        $form = $this->createForm(new \Settings\ConfigBundle\Form\StageType(), $stage);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($stage);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Stage is added');
                else $this->get('session')->getFlashBag()->add('notice','A Stage is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_stage_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Stage:form.html.twig', array(
            'stages' => $stage,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $stages = $em->getRepository('SettingsConfigBundle:Stage')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Stage:update.html.twig', array(
            'stages' => $stages,
            'stage_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $stage = $em->getRepository('SettingsConfigBundle:Stage')->find($id);

        if (!$stage) {
            throw $this->createNotFoundException('Unable to find Stage');
        }
        
        $em->remove($stage);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A stage is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_stage_list'));
    }    
}


