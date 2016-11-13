<?php
namespace lacueva\BlogBundle\Controller; // vg->lacueva\BlogBundle\Controller (el completion works);
include 'ApiGator.php';
use ApiGator\ApiGator;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use function dump;




class Express51ConversationsController extends Controller {

	private $_session;

	public function __construct() {
		$this->_session = new Session();
	}

	//_action
	

	
	public function indexAction(Request $request) {
		/*
		 * Este controller ha sido autogenerado por Passh:
		 * Ahora no vendría mal añadir en el routing.yml la ruta 
		 * que me llama.
		 * 
		 * Cuidado con los espacios si copias este skel que también es autogenerado por la template:
		 * 
		 * Express51Conversations_index:
		 *  path: /Express51Conversations/index
		 *  defaults: {_controller: lacueva\BlogBundle\Controller:Express51Conversations:index}
		 */
			
		
		$Express51ConversationsApi = new \ApiGator\ApiGator(SECTION_STATUS);
		
		
		/* @var $closureGeneraArray Closure */
		$closureGeneraArray = function( $json )
		{
			
		};
			
		$Express51ConversationsApi->procesaResponseCon($closureGeneraArray);



		//_render aqui. 
		;
		return new Response(dump($Express51ConversationsApi->curl_response) .
				"Esto es una Stub de indexAction, posiblemente quieras usar en esta linea :
		  return \$this->render(\$view)");
	}

	//PRIVS
	private function _log($dumpeame) {



		$this->_session->getFlashBag()->add("log", $string);
		dump($m);
	}

	private function _miRepo() {
		return $this->getDoctrine()->getRepository("repositorio_propio");
	}

}
