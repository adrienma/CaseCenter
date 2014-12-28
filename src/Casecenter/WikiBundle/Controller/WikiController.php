<?php

namespace Casecenter\WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WikiController extends Controller
{
    public function indexAction()
    {
        return $this->render('CasecenterWikiBundle:Wiki:index.html.twig');
    }
}
