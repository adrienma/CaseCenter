<?php

namespace Casecenter\UserBundle\Controller;

use FOS\UserBundle\Controller\GroupController as BaseController;
use Casecenter\UserBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GroupController extends BaseController
{
    public function listAction()
    {
        $groups = $this->container->get('doctrine')->getManager()->getRepository('CasecenterUserBundle:Group')->findBy(array(), array('name' => 'asc'));

    	return $this->container->get('templating')->renderResponse('CasecenterUserBundle:Group:list.html.twig', array('groups' => $groups));
    }

    public function showAction($groupName)
    {
        return new RedirectResponse($this->container->get('router')->generate('fos_user_group_list'));
    }
}