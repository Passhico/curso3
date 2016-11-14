<?php

namespace lacueva\BlogBundle\Controller;

// vg->lacueva\BlogBundle\Controller (el completion works);
include 'ApiGator.php';

use ApiGator\ApiGator;
use Closure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// https://support.ladesk.com/840770-Complete-API-reference
class Express51ConversationsController extends Controller {

	//path: /Express51Conversations/index
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


		//agents 
		// curl_setopt($ch,CURLOPT_URL,
		// "http://example.com/api/reports/agents?date_from=
		// [value]&date_to=[value]?&date_from=value&date_to=value&apikey=value");



		$ApiGatorExpress51_AGENTSREPORT = new ApiGator('reports/agents',
				                    'https://express51.ladesk.com/api/',
				                    '&apikey=10c54076befac3d7ba249637b9ee6a31',
				                    ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$ApiGatorExpress51_AGENTSREPORT->procesaResponseCon($funcionDumpComoArray);
		return new Response('Datos de la API de Express51');
	}
}
