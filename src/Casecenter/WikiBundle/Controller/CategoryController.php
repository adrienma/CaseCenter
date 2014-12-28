<?php

namespace Casecenter\WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casecenter\WikiBundle\Entity\Category;

class CategoryController extends Controller
{
    public function addAction()
    {
        /*
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setTitle('Spec tech');
        $em->persist($category);

        $category1 = new Category();
        $category1->setTitle('Display web');
        $category1->setParent($category);
        $em->persist($category1);

        $category2 = new Category();
        $category2->setTitle('Display mobile');
        $category2->setParent($category);
        $em->persist($category2);
		
		$em->flush();
        */

        return $this->render('CasecenterWikiBundle:Category:add.html.twig');
    }

    public function editAction()
    {
        return $this->render('CasecenterWikiBundle:Category:add.html.twig');
    }

    public function deleteAction()
    {
        return $this->render('CasecenterWikiBundle:Category:add.html.twig');
    }
}
