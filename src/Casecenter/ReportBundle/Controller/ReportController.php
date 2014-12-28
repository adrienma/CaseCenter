<?php

namespace Casecenter\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function indexAction()
    {
        return $this->render('CasecenterReportBundle:Report:index.html.twig');
    }
}
