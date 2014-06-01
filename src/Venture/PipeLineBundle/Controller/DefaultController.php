<?php

namespace Venture\PipeLineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/list{type}" , name="venture_pipeline_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($type="show_all") {
        return array();
    }

    /**
     * @Route("/add", name="venture_pipeline_add")
     * @Method("GET|POST")
     * @Template()
     */
    public function addAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $pipeLine = new \Venture\PipeLineBundle\Entity\PipeLine();

        $form = $this->createForm(new \Venture\PipeLineBundle\Form\PipeLineType(), $pipeLine);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($pipeLine);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice','A Pipeline entry is eneterd into the database');
                #return $this->redirect($this->generateUrl("venture_show_alternate_raw_material", array("id" => $alternateRawMaterial->getId())));
            }
        }

        return array('form' => $form->createView());
    }
}
