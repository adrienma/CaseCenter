<?php

namespace Casecenter\PlanningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\PlanningBundle\Entity\Planning;
use Casecenter\PlanningBundle\Entity\Package;
use Casecenter\PlanningBundle\Form\PackageType;


class PackageController extends Controller
{
    public function addAction(Planning $planning)
    {
        $package = new Package();
        $package->setPlanning($planning);

        $form = $this->createForm(new PackageType, $package);

        if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());
            
        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($package);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('package.new.flashmessage', array('%name%' => $package->getName())));
        		$this->get('logger')->notice('Package : ID '.$package->getId().' : Creation (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('planning_edit', array('slug' => $planning->getSlug())));
        	}
        }

        return $this->render('CasecenterPlanningBundle:Package:add.html.twig', array('planning' => $planning, 'form' => $form->createView()));
    }
/*
    public function editAction(Planning $planning)
    {

    	$form = $this->createForm(new PlanningType, $planning);

    	if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());
            
        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($planning);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('planning.edit.flashmessage', array('%name%' => $planning->getName())));
        		$this->get('logger')->notice('Planning : ID '.$planning->getId().' : Edit (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('planning_edit', array('slug' => $planning->getSlug())));
        	}
        }

    	return $this->render('CasecenterPlanningBundle:Planning:edit.html.twig', array('planning' => $planning, 'form' => $form->createView(), 'packages' => array(), 'calendars' => array()));
    }

    public function deleteAction(Planning $planning)
    {
    	if ($this->getRequest()->getMethod() == 'POST') {
    		if ($this->getRequest()->request->get('delete') == 'true') {
    			$em = $this->getDoctrine()->getManager();
        		$em->remove($planning);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('planning.delete.flashmessage', array('%name%' => $planning->getName())));
    			$this->get('logger')->notice('Planning : ID '.$planning->getId().' : Delete (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('planning_index'));
        	}
    	}

    	return $this->render('CasecenterPlanningBundle:Planning:delete.html.twig', array('planning' => $planning));
    }
*/
}
