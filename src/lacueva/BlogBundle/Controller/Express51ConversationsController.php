<?php
namespace lacueva\BlogBundle\Controller; // vg->lacueva\BlogBundle\Controller (el completion works);
include 'ApiGator.php';

use ApiGator\ApiGator;
use Closure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use const SECTION_CONVERSACIONES;
use const SECTION_STATUS;
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
			
		
		/* @var $funcionDumpComoArray Closure */
		$funcionDumpComoArray = function( $json )
		{
			$arr = json_decode($json, true);
			return new Response (dump($arr));
		};
	
		//status
		$ApiGatorExpress51_STATUS = new \ApiGator\ApiGator(SECTION_STATUS);
		$ApiGatorExpress51_STATUS->procesaResponseCon($funcionDumpComoArray);
	
		//conversations
		$ApiGatorExpress51_CONVERSATIONS = new ApiGator(SECTION_CONVERSACIONES);
		$ApiGatorExpress51_CONVERSATIONS->procesaResponseCon($funcionDumpComoArray);
		
		
		//customers
		$ApiGatorExpress51_CUSTOMERS = new ApiGator('customers');
		$ApiGatorExpress51_CUSTOMERS->procesaResponseCon($funcionDumpComoArray);
		
		
	
		
		
		
//			curl_setopt($ch,CURLOPT_URL,"http://example.com/api/reports/agents?date_from=[value]&date_to=[value]?&date_from=value&date_to=value&apikey=value");


		
	
		return new Response('Datos de la API de Express51');
		
		
		
		
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
