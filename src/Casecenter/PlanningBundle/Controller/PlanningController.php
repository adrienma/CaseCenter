<?php

namespace Casecenter\PlanningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Casecenter\PlanningBundle\Entity\Planning;
use Casecenter\PlanningBundle\Form\PlanningType;
use Casecenter\PlanningBundle\Entity\Package;
use Casecenter\PlanningBundle\Form\PackageType;
use Casecenter\PlanningBundle\Entity\Booking;
use Casecenter\PlanningBundle\Form\BookingType;
use Casecenter\PlanningBundle\Entity\BookingDate;

class PlanningController extends Controller
{
    public function indexAction()
    {
        $plannings_criteres = array('enabled' => true);
        if ($this->get('security.context')->isGranted('ROLE_PLANNING_ADMIN')) {$plannings_criteres = array();}

        $plannings = $this->getDoctrine()->getManager()->getRepository('CasecenterPlanningBundle:Planning')->findBy($plannings_criteres, array('enabled' => 'DESC', 'namePublic' => 'ASC', 'name' => 'ASC'));

        return $this->render('CasecenterPlanningBundle:Planning:index.html.twig', array('plannings' => $plannings));
    }
	
	public function addAction(Request $request)
    {
        $planning = new Planning();

        $form = $this->createForm(new PlanningType, $planning);
		
		/*
        if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());
            
        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($planning);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('planning.new.flashmessage', array('%name%' => $planning->getName())));
        		$this->get('logger')->notice('Planning : ID '.$planning->getId().' : Creation (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('planning_view', array('slug' => $planning->getSlug())));
        	}
        }
		*/

        return $this->render('CasecenterPlanningBundle:Planning:add.html.twig', array('form' => $form->createView()));
    }
	
    public function viewAction(Planning $planning)
    {
        return new Response("Hello World ! (overview)");
    }

    /*
	public function scheduleAction($slugPlanning, $slugPackage)
    {
        return new Response("Hello World ! (schedule)");
    }
	*/
	
	/*
    public function cartAction()
    {
        $bookings = $this->getDoctrine()->getManager()->getRepository('CasecenterPlanningBundle:Booking')->getWithDatesByUser($this->getUser());

        return $this->render('CasecenterPlanningBundle:Planning:cart.html.twig', array('bookings' => $bookings));
    }
	*/
	
	/*
    public function insertionorderAction(Booking $booking)
    {
        if ($booking == NULL OR $booking->getUser() != $this->getUser() OR $booking->isValid() == FALSE) {throw $this->createNotFoundException('Page not found');}

        return $this->render('CasecenterPlanningBundle:Booking:insertionorder.html.twig', array('booking' => $booking, 'user' => $this->getUser()));
    }
	*/

    public function removeAction(Booking $booking)
    {
        if ($booking == NULL OR $booking->getUser() != $this->getUser()) {throw $this->createNotFoundException('Page not found');}

        if ($this->getRequest()->getMethod() == 'POST') {
            if ($this->getRequest()->request->get('delete') == 'true') {
                $em = $this->getDoctrine()->getManager();

                foreach ($booking->getDates() as $date) {$em->remove($date);}
                $em->remove($booking);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('booking.delete.flashmessage'));
                $this->get('logger')->notice('Booking : ID '.$booking->getId().' : Delete (User ID '.$this->getUser()->getId().')');

                return $this->redirect($this->generateUrl('planning_cart'));
            }
        }

        return $this->render('CasecenterPlanningBundle:Booking:remove.html.twig', array('booking' => $booking));
    }

    public function editAction(Planning $planning)
    {
        $packages = $this->getDoctrine()->getManager()->getRepository('CasecenterPlanningBundle:Package')->findBy(array('planning' => $planning), array('name' => 'ASC'));

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

    	return $this->render('CasecenterPlanningBundle:Planning:edit.html.twig', array('planning' => $planning, 'form' => $form->createView(), 'packages' => $packages, 'calendars' => array()));
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
}
