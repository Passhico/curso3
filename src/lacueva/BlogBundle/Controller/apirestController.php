<?php

//<?php
namespace lacueva\BlogBundle\Controller; // vg->lacueva\BlogBundle\Controller (el completion works);


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use function dump;
	
	
class apiRestController extends FOSRestController
{
	
	private $_session;
		
	public function __construct()
	{
		$this->_session = new Session();
	}
		
	//_action
	public function indexAction(Request $request)
	{
		/*
		 * Este controller ha sido autogenerado por Passh:
		 * Ahora no vendría mal añadir en el routing.yml la ruta 
		 * que me llama.
		 * 
		 * Cuidado con los espacios si copias este skel que también es autogenerado por la template:
		 * 
		 * apiRest_index:
		 *  path: /apiRest/index
		 *  defaults: {_controller: lacueva\BlogBundle\Controller:apiRest:index}
		 */
			 
			 
		//_render aqui. 
		;
		return new Response(dump($this) .
				"Esto es una Stub de indexAction, posiblemente quieras usar en esta linea :
		  return \$this->render(\$view)");
	}
	//PRIVS
	private function _log($dumpeame)
	{
		
		
		$this->_session->getFlashBag()->add("log", $string);
		dump($m);
	}
	private function _miRepo()
	{
		return $this->getDoctrine()->getRepository("repositorio_propio");
	}
}