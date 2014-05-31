<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\Packaging;
use Settings\ConfigBundle\Form\PackagingType;

class PackagingController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $packagings = $em->getRepository('SettingsConfigBundle:Packaging')->getLatestPackagings();
        
        return $this->render('SettingsConfigBundle:Packaging:index.html.twig', array(
            'packagings' => $packagings,
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $packaging = (!$id) ? new Packaging() : $em->getRepository('SettingsConfigBundle:Packaging')->find($id);
        
        if(!$packaging) throw $this->createNotFoundException('Unable to find Packaging');
        
        $form = $this->createForm(new PackagingType(), $packaging);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($packaging);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A packaging value is added');
                else $this->get('session')->getFlashBag()->add('notice','packaging value is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_packaging_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Packaging:form.html.twig', array(
            'packaging' => $packaging,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $packagings = $em->getRepository('SettingsConfigBundle:Packaging')->getLatestPackagings();
        
        return $this->render('SettingsConfigBundle:Packaging:update.html.twig', array(
            'packagings' => $packagings,
            'packaging_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $packaging = $em->getRepository('SettingsConfigBundle:Packaging')->find($id);

        if (!$packaging) {
            throw $this->createNotFoundException('Unable to find packaging');
        }
        
        $em->remove($packaging);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A packaging value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_packaging_list'));
        
    }
}