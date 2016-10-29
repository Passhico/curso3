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
		$tagToAdd = new \lacueva\BlogBundle\Entity\Tags($this->getDoctrine()->getManager());

		//Creamos el form 
		$formAddTag = $this->createForm(\lacueva\BlogBundle\Form\TagsType::class, $tagToAdd);
		//Le decimos que manejará la request cuando se pulse el botón submit... 
		$formAddTag->handleRequest($request);

		$status = "El form " . $formAddTag->getName() . " ";

		if ($formAddTag->isSubmitted())
		{
			$this->_log("issubmited()");
			if ($formAddTag->isValid())
			{
				$this->_log("isValid(true)");

				//_formget 
				$tagToAdd->setName($formAddTag->get("name")->getData());
				$tagToAdd->setDescription($formAddTag->get("description")->getData());

				// _persist	
				$this->getDoctrine()->getManager()->persist($tagToAdd);
				$this->getDoctrine()->getManager()->flush();
			} else
				$this->_log("isValid(false)");
		} else
			$this->_log("sin pulsar boton");

		$this->_log("Y el nombre de la  flashbag es...: " . $this->_session->getFlashBag()->getName());
		return $this->render("addTag.html.twig", [
					"formAddTag" => $formAddTag->createView(),
					"allTag" => $this->getDoctrine()->getManager()->getRepository("BlogBundle:Tags")->findAll()
		]);
	}

	private function _log($string)
	{
		$this->_session->getFlashBag()->add("status", $string);
	}

}
