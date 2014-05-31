<?php

namespace Venture\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/list", name="venture_users_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em
            ->getRepository('VentureUserBundle:User')
            ->findBy(array(), 
                    array('updated' => 'DESC'));
        
        return array(
            'users' => $users,
        );
    }
    
    /**
     * @Route("/{id}/show", name="venture_user_view")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('VentureUserBundle:User')
            ->find($id);
        
        if(!$user) throw $this->createNotFoundException ("Requested user not found");
        
        return array(
            'user' => $user,
        );   
    }
    
    /**
     * @Route("/{id}/edit", name="venture_user_update")
     * @Method("GET|POST")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('VentureUserBundle:User')
            ->find($id);
        
        if(!$user) throw $this->createNotFoundException ("Requested user not found");
        
        $form = $this->createForm(new \Venture\UserBundle\Form\Type\UpdateUserType(), $user);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
            }
            $this->get('session')->getFlashBag()->add('notice','The User Data Is Updated');
            return $this->redirect($this->generateUrl("venture_user_view", array("id" => $user->getId())));
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/{id}/remove", name="venture_user_remove")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('VentureUserBundle:User')
            ->find($id);
        
        if(!$user) throw $this->createNotFoundException ("Requested user not found");
        
        $em->remove($user);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','User deleted');
        return $this->redirect($this->generateUrl("venture_users_list"));
    }
}
