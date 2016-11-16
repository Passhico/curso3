<?php

namespace lacueva\BlogBundle\Controller;

include_once 'ApiGator/ApiGator.php';

use ApiGator\ApiGator;
use Closure;
use lacueva\BlogBundle\Entity\cases;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;
use const SNAPCHAT_ORG_ID;
use const SNAPCHAT_URI;
use const SNAPCHAT_URL;
use const SNAPCHAT_WIDGET_ID;
use function dump;

define('SNAPCHAT_URL', 'https://www.snapengage.com/api/v2/');
define('SNAPCHAT_ORG_ID', '6418107096367104');
define('SNAPCHAT_APITOKEN', 'ebec63f521baf484da13a550a111e5d6');
define('SNAPCHAT_WIDGET_ID', '4e09afaa-f6c5-4d73-9fae-5b85b0e4aee6');

define('SNAPCHAT_URI', SNAPCHAT_URL . SNAPCHAT_ORG_ID . '/logs?widgetId=' . SNAPCHAT_WIDGET_ID . '&start=2016-11-14&end=2016-11-15');
/*
 * Crea conexiones a la api de datos de SnapChat para PcComponentes.com
 * 
 * Ejemplo de la documentación de la API :  https://developer.snapengage.com/logs-api/get-all-logs/
 * curl "https://www.snapengage.com/api/v2/{org_id}/logs?widgetId={widget_id}&start=2016-11-14&end=2016-11-15" -H "Authorization: api_token"
 *
 *  // COMANDO EN CURL QUE FUNCIONA!!!!
 * // curl "https://www.snapengage.com/api/v2/6418107096367104/logs?widgetId=4e09afaa-f6c5-4d73-9fae-5b85b0e4aee6&start=2016-11-14&end=2016-11-15"  -H "Authorization: ebec63f521baf484da13a550a111e5d6"
 * 
 * 
 * En la documentacion de la API , no hay nada sobre como obtener la respuesta con PHP , por lo que 
 * no hay ejemplos de referencia. 
 * 
 * // https://support.ladesk.com/840770-Complete-API-reference
 * 
 */

class SnapEngageChatController extends Controller {

	private $httpHeaderSnapchat;
	private $Case;

	public function __construct() {


		//la autentificacion de la API de chat se hace aqui.
		$this->httpHeaderSnapchat[] = "Accept: application/json";
		$this->httpHeaderSnapchat[] = 'Content-Type: application/json';
		$this->httpHeaderSnapchat[] = 'Content-length: 0';
		$this->httpHeaderSnapchat[] = 'Authorization: ebec63f521baf484da13a550a111e5d6';
	}

	/**
	 * 
	 * @param Request $request
	 * @return Response
	 * path : /SnapEngageChat/index
	 */
	public function indexAction(Request $request) {

		/* @var $funcionDumpDeSymfonyJsonDecodificado Closure */
		$funcionDumpDeSymfonyJsonDecodificado = function ($json) {
			//transformamos el json en un Array.
			$arr = json_decode($json, true);
			//si tenemos response que el array apunte a ella.
			//	$arr = $arr['response'] ? $arr['response'] : $arr;

			return new Response(dump($arr));
		};




		//para depuracion. 
		echo '$uri: ' . SNAPCHAT_URI . '<br>';
		echo '$uri: ' . var_dump($this->httpHeaderSnapchat) . '<br>';





		//https://symfony.com/doc/current/components/serializer.html

		$encoders = [new JsonDecode(true), new JsonEncode()];
		$normalizers = [new JsonSerializableNormalizer()];

		$serializer = new Serializer($normalizers, $encoders);

		$case = new cases();




		$ApiGatorSnapChat = new ApiGator(SNAPCHAT_URI, $this->httpHeaderSnapchat);

		$ApiGatorSnapChat->procesaResponseCon($funcionDumpDeSymfonyJsonDecodificado);


		$this->CreateEntitiesCases($ApiGatorSnapChat->getCurlResponse());



		//NO ME BORRRES o renderiza , o mejor manda a alguien a renderizar...xd .
		return new Response('Extracción de datos de Api Rest de SnapEngageChatController');
	}

	/**
	 * Procesa el json con la response de los cases. 
	 * Por cada caso crea una entidad en el ORM. 
	 * @warning NO HACE FLUSH!! 
	 * 
	 * 
	 * @param json $json
	 * @return Si quedan datos , la Uri , si ya no queda nada NULL.
	 */
	private function CreateEntitiesCases($json) {
		$caseToAdd = new cases(); //buffer
		//json2array
		$arr = json_decode($json, true);

		foreach ($arr['cases'] as $case) {
			$caseToAdd->setUrl($case['url']);
			$caseToAdd->setType($case['type']);
			$caseToAdd->setRequestedBy($case['requested_by']);
			$caseToAdd->setRequesterDetails($case['requester_details']);
			$caseToAdd->setDescription($case['description']);
			$caseToAdd->setCreatedAtDate($case['created_at_date']);
			$caseToAdd->setCreatedAtSeconds($case['created_at_seconds']);
			$caseToAdd->setCreatedAtMilliseconds($case['created_at_milliseconds']);
			$caseToAdd->setProactiveChat($case['proactive_chat']);
			$caseToAdd->setPageUrl($case['page_url']);
			$caseToAdd->setReferrerUrl($case['referrer_url']);
			$caseToAdd->setEntryUrl($case['entry_url']);
			$caseToAdd->setIpAddress($case['ip_address']);
			$caseToAdd->setUserAgent($case['user_agent']);
			$caseToAdd->setBrowser($case['browser']);
			$caseToAdd->setOs($case['os']);
			$caseToAdd->setCountryCode($case['country_code']);
			$caseToAdd->setCountry($case['country']);
			$caseToAdd->setRegion($case['region']);
			$caseToAdd->setCity($case['city']);
			$caseToAdd->setLatitude($case['latitude']);
			$caseToAdd->setLongitude($case['longitude']);
			$caseToAdd->setSourceId($case['source_id']);
			$caseToAdd->setChatWaittime($case['chat_waittime']);
			$caseToAdd->setChatDuration($case['chat_duration']);
			$caseToAdd->setLanguageCode($case['language_code']);
			$caseToAdd->setTranscripts($case['transcripts']);
			$caseToAdd->setJavascriptVariables($case['javascript_variables']);

			//dump($caseToAdd);
			var_dump(array_keys($case));
		}

		return $continueURI = ($arr['linkToNextSetOfResults'][0]) ? true : false;
	}

}
