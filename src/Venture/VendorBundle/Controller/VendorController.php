<?php

namespace Venture\VendorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Venture\VendorBundle\Entity\Vendor;


use Venture\VendorBundle\Form\Type\VendorType;

class VendorController extends Controller
{
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;
        $em = $this->getDoctrine()->getManager();
        $vendors = $em->getRepository('VentureVendorBundle:Vendor')->getLatestVendors($active);
        
        return $this->render('VentureVendorBundle:Vendor:list.html.twig', array(
            'vendors' => $vendors,
            'id' => 0,
            'status' => $active
        ));
    }
    
    public function createAction($id = false) {
        $em = $this->getDoctrine()->getManager();
        $vendor = (!$id) ? new Vendor() : $em->getRepository('VentureVendorBundle:Vendor')->find($id);
        
        if(!$vendor) throw $this->createNotFoundException('Unable to find vendor');
        
        $form = $this->createForm(new VendorType(), $vendor);
            
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            if($vendor->getId()) $this->remapChildren($vendor);
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach($vendor->getChildren() as $child) {
                    $child->setParent($vendor);
                }
                $em->persist($vendor);
                $em->flush();
                
                if(!$id) $this->get('session')->getFlashBag()->add('notice','A vendor is added');
                else $this->get('session')->getFlashBag()->add('notice','vendor is edited');
                
                return $this->redirect($this->generateUrl('VentureVendorBundle_vendor_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VentureVendorBundle:Vendor:form.html.twig', array(
            'vendor' => $vendor,
            'form'   => $form->createView(),
            'id'    =>  (!$id) ? 0 : $id
        ));
    } 
    
    public function viewAction($id) {
        $em = $this->getDoctrine()->getManager();
        $vendor = $em->getRepository('VentureVendorBundle:Vendor')->find($id);

        if (!$vendor) {
            throw $this->createNotFoundException('Unable to find vendor');
        }
        
                
        return $this->render('VentureVendorBundle:Vendor:details.html.twig', array(
            'vendor' => $vendor,
            'shipping' => $vendor->getShippingDetails(),
            'companies' => $vendor->getChildren(),
            'id' => $id,
        ));
    }   
    
    
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $vendor = $em->getRepository('VentureVendorBundle:Vendor')->find($id);

        if (!$vendor) {
            throw $this->createNotFoundException('Unable to find vendor');
        }
        
        if($vendor->getId()) $this->remapChildren($vendor);
        $em->remove($vendor);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A vendor is deleted');
        
        return $this->redirect($this->generateUrl('VentureVendorBundle_vendor_list', array('type' => 'show_all')));
        
    }
    
    public function remapChildren($vendor) {
        $em = $this->getDoctrine()->getManager();
        
        if (!$vendor) throw $this->createNotFoundException('Unable to find vendor');
        
        foreach($vendor->getChildren() as $child) {
            $child->setParent(NULL);        
        }
        
        $em->persist($vendor);
        $em->flush();       
    }
}
