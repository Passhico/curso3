<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lacueva\BlogBundle\Entity\Entries;

class DefaultController extends Controller
{
    public function indexAction()
    {

		$em = $this->getDoctrine()->getManager();
		$entry_repo = $em->getRepository('BlogBundle:Entries');
		$entries = $entry_repo->findAll();
		
		$e = new \lacueva\BlogBundle\Entity\Entries;
		foreach ($entries as $e)
		{
			echo $e->getTitle();
		}
		die();
		
		
		 //       return $this->render('BlogBundle:Default:index.html.twig');
    }
}
