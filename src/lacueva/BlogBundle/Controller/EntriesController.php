<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

class EntriesController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}

	//_action
	public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
	{

		;

		return new \Symfony\Component\HttpFoundation\Response(dump($this) .
				"Esto es una Stub de indexAction, posiblemente quieras usar en esta linea :
		  return \$this->render(\$view)");
	}

	public function addAction(\Symfony\Component\HttpFoundation\Request $request)
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

		return $this->render('BlogBundle:Category:add.html.twig', [
					'formCategoryAdd' => $formularioCategoria->createView(),
					'categorias' => $this->_miRepo()->findAll()
		]);
	}

	//PRIVS
	private function _log($dumpeame)
	{



		$this->_session->getFlashBag()->add("log", $string);
		dump($m);
	}

	private function _miRepo()
	{
		return $this->getDoctrine()->getRepository("BlogBundle:Entries");
	}

}
