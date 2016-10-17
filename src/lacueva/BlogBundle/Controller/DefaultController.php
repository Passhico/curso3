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
		
		/*Esta linea solo para que el ide autocomplete*/
		$entries[] = new \lacueva\BlogBundle\Entity\Entries();
		$entries = $entry_repo->findAll();
		
		/*Para cada entrada*/
		foreach ($entries as $e)
		{
			echo $e->getTitle();
			
			$EntryTags[] = new \lacueva\BlogBundle\Entity\Entrytag();
			$EntryTags = $e->getEntryTags();
			foreach ($EntryTags as $EntryTag)
			{
				echo "y el nombre de la tag es : " . $EntryTag->getIdTag()->getName();
			}
		}
			
		$this->get('logger')->info("Esto es un test, me ves?");
		
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
