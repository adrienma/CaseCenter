<?php

namespace Casecenter\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CampaignController extends Controller
{
    public function indexAction()
    {
        return $this->render('CasecenterAdvertisingBundle:Campaign:index.html.twig');
    }
}