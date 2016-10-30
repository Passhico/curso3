<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
//Clases principales 
use lacueva\BlogBundle\Entity\Categories;
use lacueva\BlogBundle\Form\CategoriesType;

class CategoryController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}

	public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
	{

		$categoria = new \lacueva\BlogBundle\Entity\Categories();

		$formularioCategoria = $this->createForm(\lacueva\BlogBundle\Form\CategoriesType::class);
		$formularioCategoria->handleRequest($request);



		if ($formularioCategoria->isSubmitted())
		{
			if (( $formularioCategoria->isValid()))
			{



				$categoria->setName($formularioCategoria->get("name")->getData());
				$categoria->setDescription($formularioCategoria->get("description")->getData());

				// _persist
				$this->getDoctrine()->getManager()->persist($categoria);
				if ($this->getDoctrine()->getManager()->flush())
					$this->_log("No se ha podido insertar la categoria");
			}
		}

		return $this->render("BlogBundle:Category:index.html.twig");
	}

	private function _log($string)
	{
		$this->_session->getFlashBag()->add("status", $string);
	}

	//PRIVS
	private function _miRepo()
	{
		return $this->getDoctrine()->getRepository("BlogBundle:Entries");
	}

}
