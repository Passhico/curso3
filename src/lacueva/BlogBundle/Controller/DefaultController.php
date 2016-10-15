<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lacueva\BlogBundle\Entity\Entries;

class DefaultController extends Controller
{
    private $_repoNameEntries = 'BlogBundle:Entries'; 
	
    public function indexAction()
    {

		$em = $this->getDoctrine()->getManager();
		$entry_repo = $em->getRepository('BlogBundle:Entries');
		$entries = $entry_repo->findAll();
		
		echo "OSTIA COPON ". $entries[0]->getIdCategory()->getName();
		
	  return $this->render('BlogBundle:Default:index.html.twig',
				[
				'entradas' => $entries, 
				'usuarios' => $this->getDoctrine()->getManager()->getRepository('BlogBundle:Users')->findAll(), 
				'tags' => $this->getDoctrine()->getManager()->getRepository('BlogBundle:Tags')->findAll(), 
				'categorias' => $this->getDoctrine()->getManager()->getRepository('BlogBundle:Categories')->findAll()
				]
			  );
    }
}
