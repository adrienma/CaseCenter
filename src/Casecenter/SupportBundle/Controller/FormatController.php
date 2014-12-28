<?php

namespace Casecenter\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\SupportBundle\Entity\Page;
use Casecenter\SupportBundle\Entity\Format;
use Casecenter\SupportBundle\Form\FormatType;

class FormatController extends Controller
{
    public function addAction(Page $page)
    {
        $format = new Format();
        $format->setPage($page);

        $form = $this->createForm(new FormatType, $format);

        if ($this->getRequest()->getMethod() == 'POST') {
        	$form->bind($this->getRequest());

        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($format);
        		$em->flush();

        		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('format.new.flashmessage', array('%name%' => $format->getName())));
                $this->get('logger')->notice('Format : ID '.$format->getId().' : Creation (User ID '.$this->getUser()->getId().')');

        		return $this->redirect($this->generateUrl('support_page_view', array('slugSupport' => $page->getSupport()->getSlug(), 'slugPage' => $page->getSlug())));
        	}
        }

        return $this->render('CasecenterSupportBundle:Format:add.html.twig', array('page' => $page, 'form' => $form->createView()));
    }

    public function editAction($slugSupport, $slugPage, $slugFormat)
    {
        $format = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Format')->getWithSupportAndPage($slugSupport, $slugPage, $slugFormat);

        if ($format == NULL) {throw $this->createNotFoundException('Format not found');}

        $form = $this->createForm(new FormatType, $format);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($format);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('format.edit.flashmessage', array('%name%' => $format->getName())));
                $this->get('logger')->notice('Format : ID '.$format->getId().' : Edit (User ID '.$this->getUser()->getId().')');
                
                return $this->redirect($this->generateUrl('support_page_view', array('slugSupport' => $format->getPage()->getSupport()->getSlug(), 'slugPage' => $format->getPage()->getSlug())));
            }
        }

    	return $this->render('CasecenterSupportBundle:Format:edit.html.twig', array('format' => $format, 'form' => $form->createView()));
    }

    public function deleteAction($slugSupport, $slugPage, $slugFormat)
    {
         $format = $this->getDoctrine()->getManager()->getRepository('CasecenterSupportBundle:Format')->getWithSupportAndPage($slugSupport, $slugPage, $slugFormat);

        if ($format == NULL) {throw $this->createNotFoundException('Format not found');}

        if ($this->getRequest()->getMethod() == 'POST') {
            if ($this->getRequest()->request->get('delete') == 'true') {
                $em = $this->getDoctrine()->getManager();
                $em->remove($format);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('format.delete.flashmessage', array('%name%' => $format->getName())));
                $this->get('logger')->notice('Format : ID '.$format->getId().' : Delete (User ID '.$this->getUser()->getId().')');

                return $this->redirect($this->generateUrl('support_page_view', array('slugSupport' => $format->getPage()->getSupport()->getSlug(), 'slugPage' => $format->getPage()->getSlug())));
            }
        }

        return $this->render('CasecenterSupportBundle:Format:delete.html.twig', array('format' => $format));
    }
}