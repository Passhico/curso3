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
		//rpeparamos una tag 
		$tagToAdd = new \lacueva\BlogBundle\Entity\Tags();
		
		//Creamos el form 
		$formAddTag = $this->createForm(\lacueva\BlogBundle\Form\TagsType::class, $tagToAdd);	
		//Le decimos que manejará la request cuando se pulse el botón submit... 
		$formAddTag->handleRequest($request);
		
		$status = "El form " . $formAddTag->getName() . " "; 
	
		if ($formAddTag->isSubmitted())
		{
			$status .= "issubmited()";
			if ($formAddTag->isValid())
			{
				$status .= "isValid(true)";
			} else
			{
				$status .= "isValid(false)";
			}


			$status .= "Y el nombre de la  flashbag es...: " . $this->_session->getFlashBag()->getName();

			$this->_session->getFlashBag()->add("status", $status);
		} else
			$status .= "sin pulsar boton";




		return $this->render("addTag.html.twig", [
			"formAddTag" => $formAddTag->createView()
		]);
		
		
	}

}
