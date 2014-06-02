<?php

namespace Venture\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AjaxController extends Controller
{
    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/pipe-line-customer", name="venture_customer_details_from_pipe_line", options={"expose"=true})
     * @Method("POST")
     */
    public function getCustomerDetailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('customerId');

        $entity = $em->getRepository('VentureCustomerBundle:Customer')->find($id);

        if (!$entity) {
            return new \Symfony\Component\HttpFoundation\Response();
        }

        $output = array();

        $output['contact']  = $entity->getContact1();
        $output['phone']    = $entity->getPhoneNumber();
        $output['email']    = $entity->getContact1Email();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));

        return $response;
    }

}
