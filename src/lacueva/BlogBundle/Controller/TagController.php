<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use lacueva\BlogBundle\Entity\Users;
use lacueva\BlogBundle\Form\UsersType;
//Clases principales 
use lacueva\BlogBundle\Entity\Tags;
use lacueva\BlogBundle\Form\TagsType;

class TagController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}

	function addAction(\Symfony\Component\HttpFoundation\Request $request)
	{
		//rpeparamos una tag  (y le pasamos el EM ya que hay constraints que requieren de su uso ., 
		// la restricción es "PreviamenteCreada"  y se imiplementa en el propio objeto como tiene que ser.. 
		$tagToPersist = new \lacueva\BlogBundle\Entity\Tags($this->getDoctrine()->getManager());

		//Creamos el form 
		$formAddTag = $this->createForm(\lacueva\BlogBundle\Form\TagsType::class, $tagToPersist);
		//Le decimos que manejará la request que le pasará el kernel al controlador. 
		$formAddTag->handleRequest($request);

		$status = "El form " . $formAddTag->getName() . " ";

		/*
		 * Según : http://php.net/manual/es/language.operators.logical.php
		 * Los if (usando un | ) se ejecutan de izda a derecha , y en cuanto hay un false deja de 
		 * ejecutarse , esto , afortunadamente es como en C++
		 * asi que no hace falta anidar IFs.
		 */
		if ( $formAddTag->isValid())
		{
				$this->_log("isValid(true)");

				//_formget 
				$tagToPersist->setName($formAddTag->get("name")->getData());
				$tagToPersist->setDescription($formAddTag->get("description")->getData());
				
				// _persist
				$this->getDoctrine()->getManager()->persist($tagToPersist);
				if ($this->getDoctrine()->getManager()->flush())
					$this->_log("La tag no se ha podido crear");
				
				
				return $this->redirectToRoute("blog_index_tag");
				
		}

		$this->_log("Y el nombre de la  flashbag es...: " . $this->_session->getFlashBag()->getName());
		return $this->render("addTag.html.twig", [
					"formAddTag" => $formAddTag->createView()
		]);
	}

	private function _log($string)
	{
		$this->_session->getFlashBag()->add("status", $string);
	}
	
	public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
	{
		return $this->render("BlogBundle:Tag:index.html.twig" , 
				[
					'Tag' => $this->getDoctrine()->getManager()->getRepository("BlogBundle:Tags")->findAll()
				]
				);
	}

}
