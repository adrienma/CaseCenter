<?php

namespace Casecenter\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\UserBundle\Entity\User;
use Casecenter\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller
{
    public function navAction($route)
    {
        if ($route == "index" OR $route == "dashboard") {$current = 'dashboard';}
        elseif (preg_match("#^(planning_).*#i", $route)) {$current = 'planning';}
        elseif (preg_match("#^(campaign_).*#i", $route)) {$current = 'campaign';}
        elseif (preg_match("#^(partner_).*#i", $route)) {$current = 'partner';}
        elseif (preg_match("#^(project_).*#i", $route)) {$current = 'project';}
        elseif (preg_match("#^(report_).*#i", $route)) {$current = 'report';}
        elseif (preg_match("#^(wiki_).*#i", $route)) {$current = 'wiki';}
        elseif (preg_match("#^(administration_).*#i", $route) OR preg_match("#^(fos_)?(user_).*#i", $route)) {$current = 'admin';}
        else {$current = false;}

    	return $this->render('CasecenterUserBundle:User:nav.html.twig', array('current' => $current));
    }

    public function indexAction($filter)
    {
        $users = $this->getDoctrine()->getManager()->getRepository('CasecenterUserBundle:User')->findBy(array() , array('name' => 'asc', 'firstname' => 'desc'));
        $counters = array("all" => 0, "enable" => 0, "expired" => 0, "locked" => 0, "disable" => 0);
        foreach ($users as $key => $user) {
            $counters["all"] ++;
            if (!$user->isEnabled()) {
                $counters["disable"] ++;
                if (!in_array($filter, array("all", "disable"))) {unset($users[$key]);}
            } elseif ($user->isLocked()) {
                $counters["locked"] ++;
                if (!in_array($filter, array("all", "locked"))) {unset($users[$key]);}
            } elseif ($user->isExpired()) {
                $counters["expired"] ++;
                if (!in_array($filter, array("all", "expired"))) {unset($users[$key]);}
            } else {
                $counters["enable"] ++;
                if (!in_array($filter, array("all", "enable"))) {unset($users[$key]);}
            }
        }

        

    	return $this->render('CasecenterUserBundle:User:index.html.twig', array('filter' => $filter, 'counters' => $counters, 'users' => $users));
    }

    public function newAction(Request $request)
    {
        $user = new User();
        $user->setLocked(false);

        $form = $this->createForm(new UserType($this->get('security.context')), $user);

        $form->handleRequest($request);

        if (!$user->getUsername()) {$user->setUsername(substr(strtolower($user->getFirstname()), 0, 1).strtolower($user->getName()));}

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('user.new.flashmessage', array('%name%' => $user->getFullname())));
            $this->get('logger')->notice('User #'.$user->getId().' : New (User ID '.$this->getUser()->getId().')');

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('CasecenterUserBundle:User:new.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    public function editAction(User $user, Request $request)
    {
        if ($user->isSuperAdmin() AND !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {throw new AccessDeniedException();}
        
        $groups = $this->getDoctrine()->getManager()->getRepository('CasecenterUserBundle:Group')->findBy(array() , array('name' => 'asc'));

        $form = $this->createForm(new UserType($this->get('security.context')), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('user.edit.flashmessage', array('%name%' => $user->getFullname())));
            $this->get('logger')->notice('User #'.$user->getId().' : Edit (User ID '.$this->getUser()->getId().')');

            return $this->redirect($this->generateUrl('user_edit', array('id' => $user->getId())));
        }

        return $this->render('CasecenterUserBundle:User:edit.html.twig', array('user' => $user, 'groups' => $groups, 'form' => $form->createView()));
    }

    public function deleteAction(User $user, Request $request)
    {
        if ($user->isSuperAdmin() AND !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {throw new AccessDeniedException();}

        $form = $this->createFormBuilder($user)
            ->add('delete', 'checkbox', array('label' => 'form.delete.confirmation', 'mapped' => false, 'constraints' => array(new NotBlank())))
            ->add('save', 'submit', array('label' => 'form.delete.btn'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setLocked(TRUE);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('user.delete.flashmessage', array('%name%' => $user->getFullname())));
            $this->get('logger')->notice('User #'.$user->getId().' : Delete (User ID '.$this->getUser()->getId().')');

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('CasecenterUserBundle:User:delete.html.twig', array('user' => $user, 'form' => $form->createView()));
    }
}