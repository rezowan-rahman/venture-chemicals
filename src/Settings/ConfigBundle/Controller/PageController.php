<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Settings\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {
    
    public function listAction() {
        return $this->render('SettingsConfigBundle:Page:landing.html.twig');
    }
}
