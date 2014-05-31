<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PipelinetypeController
 *
 * @author mhabub
 */
namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PipelinetypeController extends Controller{
 
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $allType = $em->getRepository('SettingsConfigBundle:Pipelinetype')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Pipelinetype:index.html.twig', array(
            'alltype' => $allType,
        ));
    }
    
    public function createAction($id=false) {
        $em = $this->getDoctrine()->getManager();
        
        $type = (!$id) ? 
                new \Settings\ConfigBundle\Entity\Pipelinetype(): 
                $em->getRepository('SettingsConfigBundle:Pipelinetype')->find($id);
        
        if(!$type) throw $this->createNotFoundException('Unable to find Type');
        
        $form = $this->createForm(new \Settings\ConfigBundle\Form\PipelinetypeType(), $type);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($type);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Type is added');
                else $this->get('session')->getFlashBag()->add('notice','A Type is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_pipelinetype_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Pipelinetype:form.html.twig', array(
            'alltype' => $type,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('SettingsConfigBundle:Pipelinetype')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Pipelinetype:update.html.twig', array(
            'alltype' => $type,
            'type_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository('SettingsConfigBundle:Pipelinetype')->find($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find Type');
        }
        
        $em->remove($type);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Type is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_pipelinetype_list'));
    }    
}


