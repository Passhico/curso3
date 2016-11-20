<?php

namespace lacueva\BlogBundle\Controller;

// vg->lacueva\BlogBundle\Controller (el completion works);
include_once 'ApiGator/ApiGator.php';

use ApiGator\ApiGatorExpress51;
use Closure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


define('SECTION_CONVERSACIONES', "conversations");
define('SECTION_STATUS', "application/status");
define('SECTION_COMPANIAS	', "companies");

// https://support.ladesk.com/840770-Complete-API-reference
class Express51ConversationsController extends Controller {

	//path: /Express51Conversations/index
	public function indexAction(Request $request) {

		/* @var $funcionDumpDeSymfony Closure */
		$funcionDumpDeSymfony = function ($json) {
			//transformamos el json en un Array.
			$arr = json_decode($json, true);
			//si tenemos response que el array apunte a ella.
			$arr = $arr['response'] ? $arr['response'] : $arr;

			return new Response(dump($arr));
		};



		//status
		$ApiGatorExpress51_STATUS = new \ApiGator\ApiGator(SECTION_STATUS);
		$ApiGatorExpress51_STATUS->procesaResponseCon($funcionDumpDeSymfony);

		//conversations
		$ApiGatorExpress51_CONVERSATIONS = new ApiGator(SECTION_CONVERSACIONES);
		$ApiGatorExpress51_CONVERSATIONS->procesaResponseCon($funcionDumpDeSymfony);

		//customers
		$ApiGatorExpress51_CUSTOMERS = new ApiGator('customers');
		$ApiGatorExpress51_CUSTOMERS->procesaResponseCon($funcionDumpDeSymfony);

		//Hay una sección de reportes , voy a hacer un volcado de varios para ver cual interesa.
		//la a_ sería ApiGatorExpress51_REPORTS . 
		$a_AGENTS = new ApiGator('reports/agents', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$a_AGENTS->procesaResponseCon($funcionDumpDeSymfony);

		$a_CHANNELS = new ApiGator('reports/channels', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$a_CHANNELS->procesaResponseCon($funcionDumpDeSymfony);

		$a_DEPARTMENTS = new ApiGator('reports/departments', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$a_DEPARTMENTS->procesaResponseCon($funcionDumpDeSymfony);

		$a_performance = new ApiGator('reports/performance', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$a_performance->procesaResponseCon($funcionDumpDeSymfony);

		$a_tags = new ApiGator('reports/tags', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', ["date_to=2017-01-01", "date_from=2015-01-01"]);
		$a_tags->procesaResponseCon($funcionDumpDeSymfony);

		$a_tickets_agentsavailability = new ApiGator('reports/tickets/agentsavailability', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', []);
		$a_tickets_agentsavailability->procesaResponseCon($funcionDumpDeSymfony);
		
		$a_tickets_load= new ApiGator('reports/tickets/load', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', []);
		$a_tickets_load->procesaResponseCon($funcionDumpDeSymfony);
		
		
		$a_tickets_slacompliance= new ApiGator('reports/tickets/slacompliance', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', []);
		$a_tickets_slacompliance->procesaResponseCon($funcionDumpDeSymfony);
		
		
		$a_tickets_agents= new ApiGator('agents/', 'https://express51.ladesk.com/api/', '&apikey=10c54076befac3d7ba249637b9ee6a31', []);
		$a_tickets_agents->procesaResponseCon($funcionDumpDeSymfony);
		
		

		//NO ME BORRRES .
		return new Response('Extracción de datos de Api Rest Express51');

	}

}
