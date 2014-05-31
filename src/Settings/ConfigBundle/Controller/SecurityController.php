<?php

namespace Settings\ConfigBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/venture/secured")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="_venture_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }
    
    /**
     * @Route("/login_check", name="_venture_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }
    
    /**
     * @Route("/logout", name="_venture_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
}
