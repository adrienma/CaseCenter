<?php

namespace Casecenter\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function indexAction()
    {
        return $this->render('CasecenterProjectBundle:Project:index.html.twig');
    }
}
