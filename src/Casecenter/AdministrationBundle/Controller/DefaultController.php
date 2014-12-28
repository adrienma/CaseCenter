<?php

namespace Casecenter\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw new AccessDeniedHttpException('Accès limité');}
    	
        return $this->render('CasecenterAdministrationBundle:Default:index.html.twig');
    }
}
