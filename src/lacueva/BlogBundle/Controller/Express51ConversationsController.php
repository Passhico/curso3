<?php

//path: /Express51Conversations/index

namespace lacueva\BlogBundle\Controller;

// vg->lacueva\BlogBundle\Controller (el completion works);
include 'ApiGator.php';

use ApiGator\ApiGator;
use Closure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Express51ConversationsController extends Controller {

	public function indexAction(Request $request) {

		/* @var $funcionDumpComoArray Closure */
		$funcionDumpComoArray = function ($json) {
			//transformamos el json en un Array.
			$arr = json_decode($json, true);
			//si tenemos response que el array apunte a ella.
			$arr = $arr['response'] ? $arr['response'] : $arr;

			return new Response(dump($arr));
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

		return new Response('Datos de la API de Express51');
	}



}
