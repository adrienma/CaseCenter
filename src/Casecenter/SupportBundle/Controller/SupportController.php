<?php

namespace Casecenter\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\SupportBundle\Entity\Support;
use Casecenter\SupportBundle\Form\SupportType;

class SupportController extends Controller
{
    public function indexAction()
    {
        $supports = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Support')->getWithPages();

    	return $this->render('CasecenterSupportBundle:Support:index.html.twig', array('supports' => $supports));
    }

    public function addAction()
    {
        $support = new Support();

        $form = $this->createForm(new SupportType, $support);

        if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());
            
        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($support);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('support.new.flashmessage', array('%name%' => $support->getName())));
        		$this->get('logger')->notice('Support : ID '.$support->getId().' : Creation (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('support_view', array('slug' => $support->getSlug())));
        	}
        }

        return $this->render('CasecenterSupportBundle:Support:add.html.twig', array('form' => $form->createView()));
    }

    public function viewAction(Support $support)
    {
        $pages = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Page')->getWithFormats($support);

    	return $this->render('CasecenterSupportBundle:Support:view.html.twig', array('support' => $support, 'pages' => $pages));
    }

    public function editAction(Support $support)
    {
        $form = $this->createForm(new SupportType, $support);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($support);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('support.edit.flashmessage', array('%name%' => $support->getName())));
                $this->get('logger')->notice('Support : ID '.$support->getId().' : Edit (User ID '.$this->getUser()->getId().')');

                return $this->redirect($this->generateUrl('support_view', array('slug' => $support->getSlug())));
            }
        }

    	return $this->render('CasecenterSupportBundle:Support:edit.html.twig', array('support' => $support, 'form' => $form->createView()));
    }

    public function deleteAction(Support $support)
    {
    	if ($this->getRequest()->getMethod() == 'POST') {
    		if ($this->getRequest()->request->get('delete') == 'true') {
    			$em = $this->getDoctrine()->getManager();
        		$em->remove($support);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('support.delete.flashmessage', array('%name%' => $support->getName())));
    			$this->get('logger')->notice('Support : ID '.$support->getId().' : Delete (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('support_index'));
        	}
    	}

    	return $this->render('CasecenterSupportBundle:Support:delete.html.twig', array('support' => $support));
    }
}