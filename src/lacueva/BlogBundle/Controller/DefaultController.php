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
		
		$e = new \lacueva\BlogBundle\Entity\Entries;
		foreach ($entries as $e)
		{
			echo $e->getTitle();
		}
		$e->setTitle("Desarrollo en Php"); 
		echo "<br>"; 
		
		if ( $this->getDoctrine()->getManager()->flush() )
			echo "error" && die();
		
	  return $this->render('BlogBundle:Default:index.html.twig',
				[
					'entradas' => $entries
					//'entradas => $this->getDoctrine()->getManager()->getRepository('')
				]
			  );
    }
}
