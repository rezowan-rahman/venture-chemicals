<?php

namespace Venture\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Venture\CustomerBundle\Entity\Customer;
use Venture\CustomerBundle\Form\Type\CustomerType;

class CustomerController extends Controller
{

    /**
     * Lists all Customer entities.
     *
     * @Route("/list/{type}", name="venture_customer_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($type = "show_all") {
        $em = $this->getDoctrine()->getManager();
        $active = ($type != "show_all") ? true: false;

        $entities = $em
            ->getRepository('VentureCustomerBundle:Customer')
            ->getLatestCustomers($active);

        $pagination = $this->get('knp_paginator')->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5
        );

        return array(
            'pagination' => $pagination,
            "status" => $active
        );
    }
    
    /**
     * Displays a form to create a new Customer entity.
     *
     * @Route("/new", name="venture_new_customer")
     * @Method("GET|POST")
     * @Template()
     */
    
    public function createAction() {
        $em = $this->getDoctrine()->getManager();
        $entity = new Customer();
        
        $form = $this->createForm(new CustomerType(), $entity);
            
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach($entity->getChildren() as $child) {
                    $child->setParent($entity);
                }
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A customer is added');
                
                return $this->redirect($this->generateUrl('venture_customer_list', array("type" => "show_all")));
            }
        }
        
        return $this->render('VentureCustomerBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    } 

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}/details", name="venture_customer_details")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('VentureCustomerBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/update", name="venture_edit_customer")
     * @Method("GET|POST")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('VentureCustomerBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }
        
        $form = $this->createForm(new CustomerType(), $entity);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            if($entity->getId()) $this->remapChildren($entity);
            $form->bind($request);
            
            if ($form->isValid()) {
                foreach($entity->getChildren() as $child) {
                    $child->setParent($entity);
                }
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A customer is Updated');
                
                return $this->redirect($this->generateUrl('venture_customer_list', array("type" => "show_all")));
            }
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}/remove", name="venture_delete_customer")
     * @Method("GET|POST")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('VentureCustomerBundle:Customer')->find($id);

        if(!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }
        
        if($entity->getId()) $this->remapChildren($entity);
        $em->remove($entity);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Customer is deleted');
        
        return $this->redirect($this->generateUrl('venture_customer_list', array("type" => "show_all")));
        
    }
    
    public function remapChildren($customer) {
        $em = $this->getDoctrine()->getManager();
        
        if (!$customer) throw $this->createNotFoundException('Unable to find customer');
        
        foreach($customer->getChildren() as $child) {
            $child->setParent(NULL);        
        }
        
        $em->persist($customer);
        $em->flush();       
    }

}
