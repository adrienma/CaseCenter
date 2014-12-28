<?php

namespace Casecenter\PlanningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\PlanningBundle\Entity\Planning;
use Casecenter\PlanningBundle\Entity\Package;
use Casecenter\PlanningBundle\Entity\Booking;
use Casecenter\PlanningBundle\Entity\Date;
use Casecenter\PlanningBundle\Form\BookingType;
use Casecenter\PlanningBundle\Entity\BookingDate;

class PlanningFootball2014Controller extends Controller
{
    public function overviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $planning = $em->getRepository('CasecenterPlanningBundle:Planning')->findOneBy(array('slug' => 'football-2014'));
        $packages = $em->getRepository('CasecenterPlanningBundle:Package')->findBy(array('planning' => $planning, "enabled" => true));

        if ($planning == NULL OR $packages == NULL OR $planning->status()["open"] == false) {throw $this->createNotFoundException('Page not found');}

        return $this->render('CasecenterPlanningBundle:PlanningFootball2014:overview.html.twig', array('planning' => $planning, 'packages' => $packages));
    }

    public function scheduleAction($slugPackage)
    {
        $em = $this->getDoctrine()->getManager();
        $planning = $em->getRepository('CasecenterPlanningBundle:Planning')->findOneBy(array('slug' => 'football-2014'));
        $package = $em->getRepository('CasecenterPlanningBundle:Package')->findOneBy(array('slug' => $slugPackage));

        if ($planning == NULL OR $package == NULL OR $planning->status()["open"] == false) {throw $this->createNotFoundException('Page not found');}

        $dates = $em->getRepository('CasecenterPlanningBundle:Date')->getWithBookings();
        
        $booking = new Booking();
        $booking->setPackage($package);
        $booking->setStatus("option");

        $form = $this->createForm(new BookingType, $booking);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em->persist($booking);
                $em->flush();
                
                foreach ($this->getRequest()->request->get('date') as $date) {
                    $_date = $em->getRepository('CasecenterPlanningBundle:Date')->findOneBy(array('id' => $date));

                    $bookingDate[$date] = new BookingDate();
                    $bookingDate[$date]->setBooking($booking);
                    $bookingDate[$date]->setDate($_date);
                    $bookingDate[$date]->setPrice($this->getRequest()->request->get($date.'_price'));
                    $bookingDate[$date]->setStatus("option");

                    $em->persist($bookingDate[$date]);
                }

                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('booking.new.flashmessage', array('%advertiser%' => $booking->getAdvertiser(), '%campaign%' => $booking->getCampaign())));
                $this->get('logger')->notice('Booking : ID '.$booking->getId().' : Creation (User ID '.$this->getUser()->getId().')');

                $message = \Swift_Message::newInstance()
                    ->setSubject($this->get('translator')->trans('booking.mail.object'))
                    ->setFrom(array('contact@amaurymediasdigital.fr' => 'Amaury Médias Digital'))
                    ->setTo($this->getUser()->getEmail())
                    ->setBody($this->renderView('CasecenterPlanningBundle:Planning:email_confirmation.html.twig', array('user' => $this->getUser(), 'planning' => $planning, 'package' => $package, 'booking' => $booking, 'bookingdate' => $bookingDate, 'url' =>$this->generateUrl('planning_cart', array(), true))), 'text/html')
                ;
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('planning_cart'));
            }
        }

        return $this->render('CasecenterPlanningBundle:PlanningFootball2014:schedule.html.twig', array('planning' => $planning, 'package' => $package, 'dates' => $dates, 'form' => $form->createView()));
    }

    public function calendarAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw new AccessDeniedHttpException('Accès limité');}

        $em = $this->getDoctrine()->getManager();

        $planning = $em->getRepository('CasecenterPlanningBundle:Planning')->findOneBy(array('slug' => 'football-2014'));
        if ($planning == NULL) {throw $this->createNotFoundException('Page not found');}

        $packages = $em->getRepository('CasecenterPlanningBundle:Package')->findBy(array('planning' => $planning, "enabled" => true));
        $dates = $em->getRepository('CasecenterPlanningBundle:Date')->findAll();

        $em->getFilters()->disable('softdeleteable');
        $bookings_query = $em->createQuery('SELECT d.id as date_id, b.advertiser, b.campaign, p.id as package_id, bd.price, b.status as booking_status, bd.status as bookingdate_status, b.creation, u.name, u.firstname, u.company, b.id as booking_id, b.archive as booking_archive, bd.archive as bookingdate_archive FROM CasecenterPlanningBundle:Date d LEFT JOIN CasecenterPlanningBundle:BookingDate bd WITH d.id = bd.date LEFT JOIN CasecenterPlanningBundle:Booking b WITH b.id = bd.booking LEFT JOIN CasecenterPlanningBundle:Package p WITH p.id = b.package LEFT JOIN CasecenterUserBundle:User u WITH u.id = b.user WHERE d.archive IS NULL AND p.archive IS NULL ORDER BY d.date ASC, bd.archive ASC, bd.status ASC, b.creation ASC');
        $bookings = $bookings_query->getResult();

        $bookings_sorting = array();
        foreach ($dates as $d) {
            foreach ($packages as $p) {
                $bookings_sorting[$d->getId()]["d"] = $d;
                $bookings_sorting[$d->getId()]["p"][$p->getId()] = NULL;
            }
        }
        foreach ($bookings as $b) {
            if ($b["booking_id"] != NULL) {
                $bookings_sorting[$b["date_id"]]["p"][$b["package_id"]][$b["booking_id"]] = $b;
            }
        }

        return $this->render('CasecenterPlanningBundle:PlanningFootball2014:calendar.html.twig', array('planning' => $planning, 'packages' => $packages, 'dates' => $dates, 'bookings' => $bookings_sorting));
    }

    public function datecloseAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw new AccessDeniedHttpException('Accès limité');}

        $em = $this->getDoctrine()->getManager();

        $planning = $em->getRepository('CasecenterPlanningBundle:Planning')->findOneBy(array('slug' => 'football-2014'));
        $date = $em->getRepository('CasecenterPlanningBundle:Date')->findOneBy(array('id' => $id, "enabled" => true));
        if ($planning == NULL or $date == NULL) {throw $this->createNotFoundException('Page not found');}

        $em->getFilters()->disable('softdeleteable');
        $bookings_query = $em->createQuery('SELECT b.id, b.advertiser, b.campaign, p.name as package_name, bd.price, b.status as booking_status, bd.status as bookingdate_status, b.creation, u.name, u.firstname, u.company, b.archive as booking_archive, bd.archive as bookingdate_archive FROM CasecenterPlanningBundle:Booking b, CasecenterPlanningBundle:BookingDate bd, CasecenterPlanningBundle:Date d, CasecenterPlanningBundle:Package p, CasecenterUserBundle:User u WHERE d.id = '.$date->getId().' AND d.id = bd.date AND bd.booking = b.id AND b.package = p.id AND p.archive IS NULL AND b.user = u.id ORDER BY bd.archive ASC, bd.status ASC, b.creation ASC');
        $bookings = $bookings_query->getResult();

        if ($this->getRequest()->getMethod() == 'POST') {
            if ($this->getRequest()->request->get('valid') == 'true') {
                $em = $this->getDoctrine()->getManager();

                //Date closing
                $date->setEnabled(false);
                $this->get('logger')->notice('Date : ID '.$date->getId().' : enabled=false (User ID '.$this->getUser()->getId().')');
                $em->persist($date);
                $this->get('session')->getFlashBag()->add('success', 'La date du '.$date->getDate()->format('d/m/Y').' a bien été fermée à la réservation.');

                //Booking confirm / option / cancel
                $booking_id_confirm = $this->getRequest()->request->get('booking');
                if ($booking_id_confirm != NULL) {
                    $bookingsdate = $em->getRepository('CasecenterPlanningBundle:BookingDate')->findBy(array('date' => $date));

                    foreach ($bookingsdate as $bd) {
                        if ($bd->getBooking()->getId() == $booking_id_confirm AND $bd->getStatus() != "confirm") {
                            $bd->setStatus("confirm");
                            $this->get('logger')->notice('BookingDate : Date ID '.$bd->getDate()->getId().' / Booking ID '.$bd->getBooking()->getId().' : status=confirm (User ID '.$this->getUser()->getId().')');
                            $this->get('session')->getFlashBag()->add('success', 'La réservation '.$bd->getBooking()->getAdvertiser().', '.$bd->getBooking()->getCampaign().' a été confirmée pour le '.$bd->getDate()->getDate()->format('d/m/Y'));
                        } elseif ($bd->getBooking()->getId() != $booking_id_confirm AND $bd->getStatus() == "confirm") {
                            $bd->setStatus("cancel");
                            $this->get('logger')->notice('BookingDate : Date ID '.$bd->getDate()->getId().' / Booking ID '.$bd->getBooking()->getId().' : status=cancel (User ID '.$this->getUser()->getId().')');
                            $this->get('session')->getFlashBag()->add('notice', 'La réservation '.$bd->getBooking()->getAdvertiser().', '.$bd->getBooking()->getCampaign().' a été annulé pour le '.$bd->getDate()->getDate()->format('d/m/Y'));
                        }
                        $em->persist($bd);
                    }
                }

                //Màj
                $em->flush();
                //Redirect
                return $this->redirect($this->generateUrl('planning_football2014_calendar'));
            } else {$this->get('session')->getFlashBag()->add('error', 'Vous devez prendre conscience et valider les conséquences de la fermeture de la date aux réservations.');}
        }

        return $this->render('CasecenterPlanningBundle:PlanningFootball2014:dateclose.html.twig', array('planning' => $planning, 'date' => $date, 'bookings' => $bookings));
    }

    public function deleteoptionAction(Date $date, Booking $booking)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw new AccessDeniedHttpException('Accès limité');}

        $em = $this->getDoctrine()->getManager();

        $planning = $em->getRepository('CasecenterPlanningBundle:Planning')->findOneBy(array('slug' => 'football-2014'));
        $bookingdate = $em->getRepository('CasecenterPlanningBundle:BookingDate')->findOneBy(array('date' => $date, 'booking' => $booking, 'archive' => NULL));
        if ($planning == NULL or $bookingdate == NULL) {throw $this->createNotFoundException('Page not found');}

        if ($this->getRequest()->getMethod() == 'POST') {
            if ($this->getRequest()->request->get('delete') == 'true') {
                $em->remove($bookingdate);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'L\'option du '.$bookingdate->getDate()->getDate()->format('d/m/Y').' pour la réservation '.$bookingdate->getBooking()->getAdvertiser().', '.$bookingdate->getBooking()->getCampaign().' a bien été supprimée.');
                $this->get('logger')->notice('BookingDate : Date ID '.$bookingdate->getDate()->getId().' / Booking ID '.$bookingdate->getBooking()->getId().' : Delete (User ID '.$this->getUser()->getId().')');

                return $this->redirect($this->generateUrl('planning_football2014_calendar'));
            }
        }

        return $this->render('CasecenterPlanningBundle:PlanningFootball2014:deleteoption.html.twig', array('planning' => $planning, 'bd' => $bookingdate));
    }
}
