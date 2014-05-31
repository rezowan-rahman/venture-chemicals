<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Salesrep
 *
 * @author mhabub
 */
namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SalesrepController extends Controller{
public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $allSalesRep = $em->getRepository('SettingsConfigBundle:Salesrep')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Salesrep:index.html.twig', array(
            'allSalesRep' => $allSalesRep,
        ));
    }
    
    public function createAction($id=false) {
        $em = $this->getDoctrine()->getManager();
        
        $salesRep = (!$id) ? 
                new \Settings\ConfigBundle\Entity\Salesrep(): 
                $em->getRepository('SettingsConfigBundle:Salesrep')->find($id);
        
        if(!$salesRep) throw $this->createNotFoundException('Unable to find Sales Rep.');
        
        $form = $this->createForm(new \Settings\ConfigBundle\Form\SalesrepType(), $salesRep);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($salesRep);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A Sales Rep. is added');
                else $this->get('session')->getFlashBag()->add('notice','A Sales Rep. is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_salesrep_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:Salesrep:form.html.twig', array(
            'alltype' => $salesRep,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $allSalesRep = $em->getRepository('SettingsConfigBundle:Salesrep')
                ->findBy(array(
                    "isActive" => true), array(
                        "updated" => "DESC"));
        
        return $this->render('SettingsConfigBundle:Salesrep:update.html.twig', array(
            'allSalesRep' => $allSalesRep,
            'sale_rep_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $salesRep = $em->getRepository('SettingsConfigBundle:Salesrep')->find($id);

        if (!$salesRep) {
            throw $this->createNotFoundException('Unable to find Sales Rep.');
        }
        
        $em->remove($salesRep);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Sales Rep. is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_salesrep_list'));
    }      
}

