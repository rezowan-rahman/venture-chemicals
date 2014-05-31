<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Settings\ConfigBundle\Entity\SalesPricePoint;
use Settings\ConfigBundle\Form\SalesPricePointType;

class SalesPricePointController extends Controller {
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $salesPricePoints = $em->getRepository('SettingsConfigBundle:SalesPricePoint')->getLatestPoints();
        
        return $this->render('SettingsConfigBundle:SalesPricePoint:index.html.twig', array(
            'salesPricePoints' => $salesPricePoints,
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        
        $salesPricePoint = (!$id) ? new SalesPricePoint() : $em->getRepository('SettingsConfigBundle:SalesPricePoint')->find($id);
        
        if(!$salesPricePoint) throw $this->createNotFoundException('Unable to find sales price point');
        
        $form = $this->createForm(new SalesPricePointType(), $salesPricePoint);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em->persist($salesPricePoint);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A sales price value is added');
                else $this->get('session')->getFlashBag()->add('notice','A sales price value is edited');
                
                return $this->redirect($this->generateUrl('SettingsConfigBundle_sales_price_point_list'));
            }
        }
        
        return $this->render('SettingsConfigBundle:SalesPricePoint:form.html.twig', array(
            'salesPricePoint' => $salesPricePoint,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    }   
   
    
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $salesPricePoints = $em->getRepository('SettingsConfigBundle:SalesPricePoint')->getLatestPoints();
        
        return $this->render('SettingsConfigBundle:SalesPricePoint:update.html.twig', array(
            'salesPricePoints' => $salesPricePoints,
            'salesPricePoint_id' => $id
        ));
    }
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $salesPricePoint = $em->getRepository('SettingsConfigBundle:SalesPricePoint')->find($id);

        if (!$salesPricePoint) {
            throw $this->createNotFoundException('Unable to find sales price point');
        }
        
        $em->remove($salesPricePoint);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A sales price value is deleted');
        
        return $this->redirect($this->generateUrl('SettingsConfigBundle_sales_price_point_list'));
        
    }
}