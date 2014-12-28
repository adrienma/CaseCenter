<?php

namespace Casecenter\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\SupportBundle\Entity\Support;
use Casecenter\SupportBundle\Entity\Page;
use Casecenter\SupportBundle\Form\PageType;

class PageController extends Controller
{
    public function addAction(Support $support)
    {
        $page = new Page();
        $page->setSupport($support);

        $form = $this->createForm(new PageType, $page);

        if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());

        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($page);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('page.new.flashmessage', array('%name%' => $page->getName())));
                $this->get('logger')->notice('Page : ID '.$page->getId().' : Creation (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('support_page_view', array('slugSupport' => $support->getSlug(), 'slugPage' => $page->getSlug())));
        	}
        }

        return $this->render('CasecenterSupportBundle:Page:add.html.twig', array('support' => $support, 'form' => $form->createView()));
    }

    public function viewAction($slugSupport, $slugPage)
    {
        $page = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Page')->getWithSupport($slugSupport, $slugPage);

        if ($page == NULL) {throw $this->createNotFoundException('Page not found');}

    	return $this->render('CasecenterSupportBundle:Page:view.html.twig', array('page' => $page));
    }

    public function editAction($slugSupport, $slugPage)
    {
        $page = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Page')->getWithSupport($slugSupport, $slugPage);

        if ($page == NULL) {throw $this->createNotFoundException('Page not found');}

        $form = $this->createForm(new PageType, $page);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('page.edit.flashmessage', array('%name%' => $page->getName())));
                $this->get('logger')->notice('Page : ID '.$page->getId().' : Edit (User ID '.$this->getUser()->getId().')');
                
                return $this->redirect($this->generateUrl('support_page_view', array('slugSupport' => $page->getSupport()->getSlug(), 'slugPage' => $page->getSlug())));
            }
        }

    	return $this->render('CasecenterSupportBundle:Page:edit.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

    public function deleteAction($slugSupport, $slugPage)
    {
        $page = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Page')->getWithSupport($slugSupport, $slugPage);

        if ($page == NULL) {throw $this->createNotFoundException('Page not found');}

        if ($this->getRequest()->getMethod() == 'POST') {
            if ($this->getRequest()->request->get('delete') == 'true') {
                $em = $this->getDoctrine()->getManager();
                $em->remove($page);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('page.delete.flashmessage', array('%name%' => $page->getName())));
                $this->get('logger')->notice('Page : ID '.$page->getId().' : Delete (User ID '.$this->getUser()->getId().')');

                return $this->redirect($this->generateUrl('support_view', array("slug" => $page->getSupport()->getSlug())));
            }
        }

        return $this->render('CasecenterSupportBundle:Page:delete.html.twig', array('page' => $page));
    }
}