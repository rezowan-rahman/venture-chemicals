<?php

namespace Venture\PipeLineBundle\Controller;

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
     * @Route("/customer-data", name="venture_customer_details_from_pipe_line", options={"expose"=true})
     * @Method("POST")
     */
    public function getCustomerDetailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('customerId');

        $entity = $em->getRepository('VentureCustomerBundle:Customer')->find($id);

        $response = new \Symfony\Component\HttpFoundation\Response();

        if (!$entity) {
            return $response;
        }

        $output = array();

        $output['contact']  = $entity->getContact1();
        $output['phone']    = $entity->getPhoneNumber();
        $output['email']    = $entity->getContact1Email();

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));

        return $response;
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/stage-data", name="venture_stage_details_from_pipe_line", options={"expose"=true})
     * @Method("POST")
     */

    public function getStageDetailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('stageId');

        $entity = $em->getRepository('SettingsConfigBundle:Stage')->find($id);

        $response = new \Symfony\Component\HttpFoundation\Response();

        if (!$entity) {
            return $response;
        }

        $output = array();
        $output['name'] = $this->calculate($entity->getName());

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));

        return $response;
    }

    public function calculate($name) {
        $modName = preg_replace('/[a-zA-Z ()\%]/', '', $name);
        $modFloatName = floatval($modName);
        return ($modFloatName/100);
    }
}
