<?php

namespace Venture\FinishedProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Venture\FinishedProductBundle\Entity\FinishedProduct;
use Venture\CommonBundle\Entity\Property;
use Venture\CommonBundle\Entity\Formula;
use Venture\CommonBundle\Entity\DataChangeLog;

use Venture\FinishedProductBundle\Form\Type\FinishedProductType;

use Doctrine\Common\Collections\ArrayCollection;

class DefaultController extends Controller
{
    
    public function initDoctrine() {
        return $em = $this->getDoctrine()->getManager();
    } 
    
    /**
     * @Route("/list/{type}", name="venture_finished_product_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($type = "show_all") {
        $active = ($type != "show_all") ? true: false;
        $em = $this->initDoctrine();
        $finishedProducts = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->getLatestProducts($active);
        
        return $this->render('VentureFinishedProductBundle:Default:list.html.twig', array(
            'finishedProducts' => $finishedProducts,
            'status' => $active
        ));
    }
    
    
    /**
     * @Route("/{id}/details", name="venture_finished_product_view")
     * @Method("GET")
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->initDoctrine();
        $finishedProduct = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->find($id);
        
        if (!$finishedProduct) {
            throw $this->createNotFoundException('Unable to find Product data');
        }
        
        return $this->render('VentureFinishedProductBundle:Default:details.html.twig', array(
            'finishedProduct'   => $finishedProduct,
            'properties'        => $finishedProduct->getProperties(),
            'formulas'          => $finishedProduct->getFormulas(),
            'total_percentage'  => $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->getTotalPercentage($id),
            'quoting_cost'      => $finishedProduct->getQuotingCost(),
            'lowest_cost'       => $finishedProduct->getLowestCost(),
            'id'                => $id,
            'versions'          => $finishedProduct->getChangeLogs(),
            'spCosts'           => $finishedProduct->getSalesPointCosts(),
            'competitiveProducts' => $finishedProduct->getCompetitiveProducts(),
        ));
    }
    
    /**
     * @Route("/add", name="venture_finished_product_add")
     * @Method("GET|POST")
     * @Template()
     */
    public function addAction(Request $request) {
        $em = $this->initDoctrine();
                
        $finishedProduct = new FinishedProduct();
        
        $form = $this->createForm(new FinishedProductType(), $finishedProduct);
        $form->handleRequest($request);

        
        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                foreach($finishedProduct->getTags() as $tag) {
                    $tag->addFinishedProduct($finishedProduct);
                }
                foreach($finishedProduct->getSalesPointCosts() as $spCost) {
                    $spCost->setFinishedProduct($finishedProduct);
                }
                foreach($finishedProduct->getProperties() as $prop) {
                    $prop->addFinishedProduct($finishedProduct);
                }
                foreach($finishedProduct->getFormulas() as $formula) {
                    $formula->addFinishedProduct($finishedProduct);
                }
                
                $maxCost = $this->processQuotingCost($finishedProduct->getFormulas());
                $finishedProduct->setQuotingCost($maxCost);
                
                $minCost = $this->processLowestCost($finishedProduct->getFormulas());
                $finishedProduct->setLowestCost($minCost);
                
                $em->persist($finishedProduct);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice','A FInished Product is added');
                return $this->redirect($this->generateUrl('venture_finished_product_list', array('type' => 'show_all')));
            }
        }
        
        return $this->render('VentureFinishedProductBundle:Default:template.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    
    /**
     * @Route("/{id}/update", name="venture_finished_product_update")
     * @Method("GET|POST")
     * @Template()
     */
    
    public function editAction(Request $request, $id) {
        $em = $this->initDoctrine();
        $finishedProduct = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->find($id);

        if (!$finishedProduct) {
            throw $this->createNotFoundException("No data found");
        }

        $logData = $this->processChangeLogData($finishedProduct);

        $originalTags           = new ArrayCollection();
        $originalSpCosts        = new ArrayCollection();
        $originalProperties     = new ArrayCollection();
        $originalFormulas       = new ArrayCollection();
        $originalCProducts      = new ArrayCollection();

        foreach ($finishedProduct->getTags() as $tag) {
            $originalTags->add($tag);
        }

        foreach ($finishedProduct->getSalesPointCosts() as $spCost) {
            $originalSpCosts->add($spCost);
        }
        
        foreach ($finishedProduct->getProperties() as $property) {
            $originalProperties->add($property);
        }
        
        foreach ($finishedProduct->getFormulas() as $formula) {
            $originalFormulas->add($formula);
        }
        
        foreach ($finishedProduct->getCompetitiveProducts() as $cProduct) {
            $originalCProducts->add($cProduct);
        }
        
        $form = $this->createForm(new FinishedProductType(), $finishedProduct);

        $form->handleRequest($request);

        if ($form->isValid()) {

            foreach($originalTags as $tag) {
                if (false === $finishedProduct->getTags()->contains($tag)) {
                    $tag->removeFinishedProduct($finishedProduct);
                }
            }

            foreach($originalSpCosts as $spCost) {
                if (false === $finishedProduct->getSalesPointCosts()->contains($spCost)) {
                    $em->remove($spCost);
                }
            }
                    
            foreach ($originalProperties as $property) {
                if (false === $finishedProduct->getProperties()->contains($property)) {
                    $property->removeFinishedProduct($finishedProduct);
                    $em->remove($property);
                }
            }
            
            foreach ($originalFormulas as $formula) {
                if (false === $finishedProduct->getFormulas()->contains($formula)) {
                    $formula->removeFinishedProduct($finishedProduct);
                    $em->remove($formula);
                }
            }
            
            foreach ($originalCProducts as $cProduct) {
                if (false === $finishedProduct->getCompetitiveProducts()->contains($cProduct)) {
                    $finishedProduct->removeCompetitiveProduct($cProduct);
                }
            }

            foreach($finishedProduct->getTags() as $tag) {
                if (false === $tag->getFinishedProducts()->contains($finishedProduct)) {
                    $tag->addFinishedProduct($finishedProduct);
                }
            }

            foreach($finishedProduct->getSalesPointCosts() as $spCost) {
                $spCost->setFinishedProduct($finishedProduct);
            }
            
            foreach($finishedProduct->getProperties() as $prop) {
                if (false === $prop->getFinishedProducts()->contains($finishedProduct)) {
                    $prop->addFinishedProduct($finishedProduct);
                }
            }
            
            foreach($finishedProduct->getFormulas() as $formula) {
                if (false === $formula->getFinishedProducts()->contains($finishedProduct)) {
                    $formula->addFinishedProduct($finishedProduct);
                }
            }
            
            $maxCost = $this->processQuotingCost($finishedProduct->getFormulas());
            $finishedProduct->setQuotingCost($maxCost);
                
            $minCost = $this->processLowestCost($finishedProduct->getFormulas());
            $finishedProduct->setLowestCost($minCost);
            
            $logObject = new \Venture\CommonBundle\Entity\DataChangeLog();
            $logObject->setFinishedProduct($finishedProduct);
            $logObject->setData(serialize($logData));
            $logObject->setReasonForChange($logData["reasonForChange"]);
            $logObject->setLoggedAt($logData["revisionDate"]);
            
            $finishedProduct->addChangeLog($logObject);
            
            $em->persist($finishedProduct);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice','A FInished Product is Updated');
            return $this->redirect($this->generateUrl('venture_finished_product_list', array('type' => 'show_all')));
        }

        return $this->render('VentureFinishedProductBundle:Default:template.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }
    
    /**
     * @Route("/{id}/remove", name="venture_finished_product_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($id) {
        $em = $this->initDoctrine();
        $finishedProduct = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->find($id);

        if (!$finishedProduct) {
            throw $this->createNotFoundException('Unable To Find Finished Product');
        }
        
        $em->remove($finishedProduct);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice','A Product Is Deleted');
        
        return $this->redirect($this->generateUrl('venture_finished_product_list', array('type' => 'show_all')));
    }
    
    /**
     * @Route("/{id}/history", name="venture_finished_product_history")
     * @Method("GET")
     * @Template()
     */
    public function revisionListAction($id) {
        $em = $this->initDoctrine();
        
        $finishedProduct = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->find($id);
        
        $versions = $em->getRepository('VentureCommonBundle:DataChangeLog')->findBy(
                array("finishedProduct" => $finishedProduct),
                array("loggedAt" => "DESC"));
        
        if (!$finishedProduct) {
            throw $this->createNotFoundException('Unable to find Product data');
        }
        
        return $this->render('VentureFinishedProductBundle:Default:history_list.html.twig', array(
            "finishedProduct"   => $finishedProduct,
            "versions"          => $versions,
        ));
    }
    
    /**
     * @Route("/history/{id}/details", name="venture_finished_product_history_details")
     * @Method("GET")
     * @Template()
     */
    public function revisionDetailsAction($id) {
        $em = $this->initDoctrine();
         
        $finishedProductLog = $em->getRepository('VentureCommonBundle:DataChangeLog')->find($id);
        
        if (!$finishedProductLog) {
            throw $this->createNotFoundException('Requested Revision is not found');
        }
        
        return $this->render('VentureFinishedProductBundle:Default:history_details.html.twig', array(
            'finishedProduct'   => unserialize($finishedProductLog->getData()),
        ));
    }
    
    public function processChangeLogData($finishedProduct) {
        $em = $this->initDoctrine();
        $log = array();
        $log["itemNumber"]              = $finishedProduct->getItemNumber();
        $log["itemName"]                = $finishedProduct->getItemName();
        $log["itemDescription"]         = $finishedProduct->getItemDescription();
        $log["configPackaging"]         = $finishedProduct->getConfigPackaging()->getName();
        $log["quotingCost"]             = $finishedProduct->getQuotingCost();
        $log["lowestCost"]              = $finishedProduct->getLowestCost();
        $log["reasonForChange"]         = $finishedProduct->getReasonForChange();
        $log["standardCost"]            = $finishedProduct->getStandardCost();
        $log["salesPointCosts"]         = array();
        $log["properties"]              = array();
        $log["formulas"]                = array();


        $i = 0;
        foreach($finishedProduct->getTags() as $tag) {
            $log["tags"][$i] = $tag->getName();
            $i++;
        }

        $i = 0;
        foreach($finishedProduct->getSalesPointCosts() as $spCost) {
            $log["salesPointCosts"][$i]["salesCostPoint"]          = $spCost->getSalesPricePoint()->getSalesCostPoint();
            $log["salesPointCosts"][$i]["cost"]                    = $spCost->getCost();
            $i++;
        }
        
        $i = 0;
        foreach($finishedProduct->getProperties() as $prop) {
            $log["properties"][$i]["property"]          = $prop->getProperty()->getName();
            $log["properties"][$i]["specification"]     = $prop->getSpecification();
            $log["properties"][$i]["specificationMath"] = $prop->getSpecificationMath();
            $log["properties"][$i]["testProcedure"]     = $prop->getTestProcedure()->getName();
            $i++;
        }
        
        $i = 0;
        foreach($finishedProduct->getFormulas() as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $log["formulas"][$i]["rawMaterial"]      = $formula->getRawMaterial()->getItemName();
            }
            if(is_object($formula->getIngredient())) {
                $log["formulas"][$i]["intermediate"]      = $formula->getIngredient()->getItemName();
            }
            $log["formulas"][$i]["amount"]            = $formula->getAmount();
            $i++;
        }
        
        $log["totalPercentage"] = $em->getRepository('VentureFinishedProductBundle:FinishedProduct')->getTotalPercentage($finishedProduct->getId());
        $log["amountInStock"] = 0;
        $log["amountInPurchaseOrder"] = 0;
        $log["reorderPoint"] = $finishedProduct->getReorderPoint();
        $log["revisionDate"] = $finishedProduct->getUpdated();
        
        return $log;
    }
    
    public function processQuotingCost($formulas) {
        $cost = 0;
        foreach($formulas as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $weight = $formula->getFinishedProduct()->getConfigPackaging()->getValue();
                $materialCost = $formula->getRawMaterial()->getQuotingCost();
                $amount = $formula->getAmount() /100;
                
                $cost = $cost + $weight*($materialCost*$amount);
            }
            
            if(is_object($formula->getIngredient())) {
                $weight = $formula->getFinishedProduct()->getConfigPackaging()->getValue();
                $materialCost = $formula->getIngredient()->getQuotingCost();
                $amount = $formula->getAmount() /100;
                
                $cost = $cost + $weight*($materialCost*$amount);
            }
        }
        
        return $cost;
    }
    
    public function processLowestCost($formulas) {
        $cost = 0;
        foreach($formulas as $formula) {
            if(is_object($formula->getRawMaterial())) {
                $weight = $formula->getFinishedProduct()->getConfigPackaging()->getValue();
                $materialCost = $formula->getRawMaterial()->getLowestCost();
                $amount = $formula->getAmount() /100;
                
                $cost = $cost + $weight*($materialCost*$amount);
            }
            
            if(is_object($formula->getIngredient())) {
                $weight = $formula->getFinishedProduct()->getConfigPackaging()->getValue();
                $materialCost = $formula->getIngredient()->getLowestCost();
                $amount = $formula->getAmount() /100;
                
                $cost = $cost + $weight*($materialCost*$amount);
            }
        }
        
        return $cost;
    }
    
}
