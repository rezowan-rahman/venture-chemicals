<?php

namespace Venture\DashBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function summaryAction()
    {
        $name = "Rezowan";
        return $this->render('VentureDashBoardBundle:Index:summary.html.twig', array('name' => $name));
    }
}
