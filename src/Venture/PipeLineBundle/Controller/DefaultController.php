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
     * @Route("/list/{type}" , name="venture_pipeline_list")
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
                foreach($pipeLine->getYearSales() as $yearSale) {
                    $yearSale->setPipeLine($pipeLine);
                }
                foreach($pipeLine->getNotes() as $note) {
                    $note->setPipeLine($pipeLine);
                }
                $pipeLine->setGoal($this->calculateGoal($pipeLine));
                $em->persist($pipeLine);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice','A Pipeline is added, please review');
                return $this->redirect($this->generateUrl("venture_pipeline_update", array("id" => $pipeLine->getId())));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{id}/update", name="venture_pipeline_update")
     * @Method("GET|POST")
     * @Template()
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $pipeLine = $em->getRepository("VenturePipeLineBundle:PipeLine")->find($id);

        if(!$pipeLine) {
            throw $this->createNotFoundException('Unable to find Pipe Line data');
        }

        $originalYearSales = new \Doctrine\Common\Collections\ArrayCollection();
        $originalNotes = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($pipeLine->getYearSales() as $yearSale) {
            $originalYearSales->add($yearSale);
        }

        foreach ($pipeLine->getNotes() as $note) {
            $originalNotes->add($note);
        }

        $form = $this->createForm(new \Venture\PipeLineBundle\Form\PipeLineType(), $pipeLine);

        $form->get("contact")->setData($pipeLine->getcustomer()->getContact1());
        $form->get("phone")->setData($pipeLine->getcustomer()->getPhoneNumber());
        $form->get("email")->setData($pipeLine->getcustomer()->getContact1Email());

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                foreach ($originalYearSales as $yearSale) {
                    if (false === $pipeLine->getYearSales()->contains($yearSale)) {
                        $em->remove($yearSale);
                    }
                }

                foreach ($originalNotes as $note) {
                    if (false === $pipeLine->getNotes()->contains($note)) {
                        $em->remove($note);
                    }
                }

                foreach($pipeLine->getYearSales() as $yearSale) {
                    $yearSale->setPipeLine($pipeLine);
                }
                foreach($pipeLine->getNotes() as $note) {
                    $note->setPipeLine($pipeLine);
                }

                $pipeLine->setGoal($this->calculateGoal($pipeLine));
                $em->persist($pipeLine);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice','A Pipeline entry is entered into the database');
                #return $this->redirect($this->generateUrl("venture_pipeline_update", array("id" => $pipeLine->getId())));
            }
        }

        return array('form' => $form->createView());
    }

    public function calculateGoal(\Venture\PipeLineBundle\Entity\PipeLine $pipeLine) {
        $priorYear = date("Y")-1;

        $total = 1;

        foreach($pipeLine->getYearSales() as $yearSale) {
            $year = $yearSale->getYear();
            if($year == $priorYear) {
                $total = $yearSale->getTotal();
            }
        }

        $probability                = $pipeLine->getProbability();
        $potential                  = $pipeLine->getPotential();
        $prior_year_growth_expected = $pipeLine->getExpectedAnnualGrowth();
        $prior_year_sales           = $total;

        return ($probability * ($potential + ((1 + $prior_year_growth_expected) * $prior_year_sales)));
    }
}
