<?php

namespace Casecenter\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PartnerController extends Controller
{
    public function indexAction()
    {
        return $this->render('CasecenterAdvertisingBundle:Partner:index.html.twig');
    }
}