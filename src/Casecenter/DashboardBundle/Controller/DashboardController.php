<?php

namespace Casecenter\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('CasecenterDashboardBundle:Dashboard:index.html.twig');
    }
}