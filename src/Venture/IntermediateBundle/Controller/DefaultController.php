<?php

namespace Venture\IntermediateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Venture\IntermediateBundle\Entity\Intermediate;
use Venture\CommonBundle\Entity\Property;
use Venture\CommonBundle\Entity\Formula;
use Venture\CommonBundle\Entity\DataChangeLog;

use Venture\IntermediateBundle\Form\Type\IntermediateType;

use Doctrine\Common\Collections\ArrayCollection;

class DefaultController extends Controller
{
    
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    } 
    
    /**
     * @Route("/list/{type}", name="venture_intermediate_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;
        $em = $this->initDoctrine();

        $intermediates = $em
            ->getRepository('VentureIntermediateBundle:Intermediate')
            ->getLatestIntermediates($active);

        $pagination = $this->get('knp_paginator')->paginate(
            $intermediates,
            $this->get('request')->query->get('page', 1),
            5
        );
        
        return $this->render('VentureIntermediateBundle:Default:list.html.twig', array(
            'intermediates' => $intermediates,
            'pagination' => $pagination,
            'status' => $active
        ));
    }
    
    /**
     * @Route("/{id}/details", name="venture_intermediate_view")
     * @Method("GET")
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->initDoctrine();
        $intermediate = $em->getRepository('VentureIntermediateBundle:Intermediate')->find($id);
        
        if (!$intermediate) {
            throw $this->createNotFoundException('Unable to find Intermediate data');
        }
        
        return $this->render('VentureIntermediateBundle:Default:details.html.twig', array(
            'intermediate'      => $intermediate,
            'properties'        => $intermediate->getProperties(),
            'formulas'          => $intermediate->getFormulas(),
            'total_percentage'  => $this->calculateTotalPercentage($intermediate),
            'quoting_cost'      => $intermediate->getQuotingCost(),
            'lowest_cost'       => $intermediate->getLowestCost(),
            'id'                => $id,
            'versions'          => $intermediate->getChangeLogs(),
        ));
    }
    
    /**
     * @Route("/add", name="venture_intermediate_add")
     * @Method("GET|POST")
     * @Template()
     */
    public function addAction(Request $request) {
        $em = $this->initDoctrine();
                
        $intermediate = new Intermediate();
        
        $form = $this->createForm(new IntermediateType(), $intermediate);
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {
                foreach($intermediate->getTags() as $tag) {
                    $tag->addIntermediate($intermediate);
                }
                foreach($intermediate->getProperties() as $prop) {
                    $prop->addIntermediate($intermediate);
                }
                foreach($intermediate->getFormulas() as $formula) {
                    $formula->addIntermediate($intermediate);
                }
                
                $maxCost = $this->processQuotingCost($intermediate->getFormulas());
                $intermediate->setQuotingCost($maxCost);
                
                $minCost = $this->processLowestCost($intermediate->getFormulas());
                $intermediate->setLowestCost($minCost);
                
                $em->persist($intermediate);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A Intermediate is added');
                return $this->redirect($this->generateUrl('venture_intermediate_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VentureIntermediateBundle:Default:template.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/{id}/update", name="venture_intermediate_update")
     * @Method("GET|POST")
     * @Template()
     */
    
    public function editAction($id, Request $request) {
        $em = $this->initDoctrine();
        $intermediate = $em->getRepository('VentureIntermediateBundle:Intermediate')->find($id);

        if (!$intermediate) {
            throw $this->createNotFoundException("No data found");
        }

        $logData = $this->processChangeLogData($intermediate);

        $originalTags = new ArrayCollection();
        $originalProperties = new ArrayCollection();
        $originalFormulas = new ArrayCollection();

        foreach ($intermediate->getTags() as $tag) {
            $originalTags->add($tag);
        }

        foreach ($intermediate->getProperties() as $property) {
            $originalProperties->add($property);
        }
        
        foreach ($intermediate->getFormulas() as $formula) {
            $originalFormulas->add($formula);
        }
        
        $form = $this->createForm(new IntermediateType(), $intermediate);

        $form->handleRequest($request);

        if ($form->isValid()) {

            foreach ($originalTags as $tag) {
                if (false === $intermediate->getTags()->contains($tag)) {
                    $tag->removeIntermediate($intermediate);
                }
            }

            foreach ($originalProperties as $property) {
                if (false === $intermediate->getProperties()->contains($property)) {
                    $property->removeIntermediate($intermediate);
                    $em->remove($property);
                }
            }
            
            foreach ($originalFormulas as $formula) {
                if (false === $intermediate->getFormulas()->contains($formula)) {
                    $formula->removeIntermediate($intermediate);
                    $em->remove($formula);
                }
            }

            foreach($intermediate->getTags() as $tag) {
                if (false === $tag->getIntermediates()->contains($intermediate)) {
                    $tag->addIntermediate($intermediate);
                }
            }

            foreach($intermediate->getProperties() as $prop) {
                if (false === $prop->getIntermediates()->contains($intermediate)) {
                    $prop->addIntermediate($intermediate);
                }
            }
            
            foreach($intermediate->getFormulas() as $formula) {
                if (false === $formula->getIntermediates()->contains($intermediate)) {
                    $formula->addIntermediate($intermediate);
                }
            }
            
            $maxCost = $this->processQuotingCost($intermediate->getFormulas());
            $intermediate->setQuotingCost($maxCost);
                
            $minCost = $this->processLowestCost($intermediate->getFormulas());
            $intermediate->setLowestCost($minCost);
            
            $logObject = new \Venture\CommonBundle\Entity\DataChangeLog();
            $logObject->setData(serialize($logData));
            $logObject->setReasonForChange($logData["reasonForChange"]);
            $logObject->setLoggedAt($logData["revisionDate"]);

            $logObject->getIntermediates()->add($intermediate);
            $intermediate->getChangeLogs()->add($logObject);
            
            $em->persist($intermediate);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice','A Intermediate is Updated');
            return $this->redirect($this->generateUrl('venture_intermediate_list', array('type' => 'show_all')));
        }

        return $this->render('VentureIntermediateBundle:Default:template.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }
    
    /**
     * @Route("/{id}/remove", name="venture_intermediate_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($id) {
        $em = $this->initDoctrine();
        $intermediate = $em->getRepository('VentureIntermediateBundle:Intermediate')->find($id);

        if (!$intermediate) {
            throw $this->createNotFoundException('Unable To Find Intermediate');
        }
        
        $em->remove($intermediate);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Intermediate Is Deleted');
        
        return $this->redirect($this->generateUrl('venture_intermediate_list', array('type' => 'show_all')));
    }
    
    /**
     * @Route("/{id}/history", name="venture_intermediate_history")
     * @Method("GET")
     * @Template()
     */
    public function revisionListAction($id) {
        $em = $this->initDoctrine();
        $intermediate = $em->getRepository('VentureIntermediateBundle:Intermediate')->find($id);
        
        if (!$intermediate) {
            throw $this->createNotFoundException('Unable to find Intermediate data');
        }
        
        return $this->render('VentureIntermediateBundle:Default:history_list.html.twig', array(
            "intermediate"   => $intermediate,
            "versions"       => $intermediate->getChangeLogs(),
        ));
    }
    
    /**
     * @Route("/history/{id}/details", name="venture_intermediate_history_details")
     * @Method("GET")
     * @Template()
     */
    public function revisionDetailsAction($id) {
        $em = $this->initDoctrine();
         
        $intermediateLog = $em->getRepository('VentureCommonBundle:DataChangeLog')->find($id);
        
        if (!$intermediateLog) {
            throw $this->createNotFoundException('Requested Revision is not found');
        }
        
        return $this->render('VentureIntermediateBundle:Default:history_details.html.twig', array(
            'intermediate'   => unserialize($intermediateLog->getData()),
        ));
    }
    
    public function processChangeLogData($intermediate) {
        $em = $this->initDoctrine();
        $log = array();
        $log["itemNumber"]              = $intermediate->getItemNumber();
        $log["itemName"]                = $intermediate->getItemName();
        $log["itemDescription"]         = $intermediate->getItemDescription();
        $log["unitOfMeasure"]           = $intermediate->getUnitOfMeasure()->getName();
        $log["quotingCost"]             = $intermediate->getQuotingCost();
        $log["lowestCost"]              = $intermediate->getLowestCost();
        $log["reasonForChange"]         = $intermediate->getReasonForChange();
        $log["tags"]                    = array();
        $log["properties"]              = array();
        $log["formulas"]                = array();

        $i = 0;
        foreach($intermediate->getTags() as $tag) {
            $log["tags"][$i] = $tag->getName();
            $i++;
        }

        $i = 0;
        foreach($intermediate->getProperties() as $prop) {
            $log["properties"][$i]["property"]          = $prop->getProperty()->getName();
            $log["properties"][$i]["specification"]     = $prop->getSpecification();
            $log["properties"][$i]["specificationMath"] = $prop->getSpecificationMath();
            $log["properties"][$i]["testProcedure"]     = $prop->getTestProcedure()->getName();
            $i++;
        }
        
        $i = 0;
        foreach($intermediate->getFormulas() as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $log["formulas"][$i]["rawMaterial"]      = $formula->getRawMaterial()->getItemName();
            }
            if(is_object($formula->getIngredient())) {
                $log["formulas"][$i]["intermediate"]      = $formula->getIngredient()->getItemName();
            }
            $log["formulas"][$i]["amount"]            = $formula->getAmount();
            $i++;
        }
        
        $log["totalPercentage"] = $this->calculateTotalPercentage($intermediate);
        $log["amountInStock"] = 0;
        $log["revisionDate"] = $intermediate->getUpdated();
        
        return $log;
    }
    
    public function processQuotingCost($formulas) {
        $cost = 0;
        foreach($formulas as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $cost = $cost + ($formula->getRawMaterial()->getQuotingCost() * ($formula->getAmount() /100));
            }
            
            if(is_object($formula->getIngredient())) {
                $cost = $cost + ($formula->getIngredient()->getQuotingCost() * ($formula->getAmount() /100));
            }
        }
        
        return $cost;
    }
    
    public function processLowestCost($formulas) {
        $cost = 0;
        foreach($formulas as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $cost = $cost + ($formula->getRawMaterial()->getLowestCost() * ($formula->getAmount() /100));
            }
            
            if(is_object($formula->getIngredient())) {
                $cost = $cost + ($formula->getIngredient()->getLowestCost() * ($formula->getAmount() /100));
            }
        }
        
        return $cost;
    }

    public function calculateTotalPercentage($intermediate) {
        if (!$intermediate) {
            throw $this->createNotFoundException('Requested Revision is not found');
        }

        $amount = 0;
        foreach($intermediate->getFormulas() as $formula) {
            $amount = $amount + $formula->getAmount();
        }

        return $amount;
    }
}
