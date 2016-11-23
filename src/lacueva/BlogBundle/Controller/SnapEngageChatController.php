<?php

namespace lacueva\BlogBundle\Controller;

include_once 'ApiGator/ApiGator.php'; //para cuando en el json falta algun indice (campo)

use ApiGator\ApiGator;
use lacueva\BlogBundle\Entity\Cases;
use lacueva\BlogBundle\Entity\Transcript;
use lacueva\BlogBundle\Repository\casesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

	/**
	 * En esta API se autentica en la cabecera HTTP .
	 * así que preparamos una personalizada.
	 *
	 * @var array
	 */
	private $HttpHeaderSnapchat;

	/* @var $repo casesRepository */
	private $RepoCases;

	/* @var $repo casesRepository */
	private $RepoTranscripts;
	//counters
	private $CounterBloqueDatos100Registros;

	/*	 * ****************************COUNTERS***************************** */

	/**
	 * El Número de Cases Leeidos en el Json .
	 * Son los intentos que hace el try para persistirlos .
	 *
	 * @var int
	 */
	private $counterTrysToPersist;
	private $CounterCasosPersistidos;

	/**
	 * Promedio de registros insertados satisfactoriamente.
	 *
	 * @var float
	 */
	private $pctSucessfully; //TODO: getter = $CounterCasePersistedSucessfully / $counterTrysToPersist
	private $CounterIndexException;
	private $CounterLineas;
	private $CounterChatsLeidos;
	private $CounterLineasPersistidas;

	/*	 * ***************************************************************** */

	public function __construct() {

		//http://us2.php.net/manual/en/function.set-time-limit.php
		set_time_limit(3600); //elimina limintación de 60 segundos , mejor 1 hora.

		$this->CounterBloqueDatos100Registros = 0;
		$this->CounterCasosPersistidos = 0;

		$this->CounterLineas = 0;
		$this->CounterLineasPersistidas = 0;
		$this->CounterChatsLeidos = 0;

		$this->pctSucessfully = 0;

		//$this->repoCases = $this->getDoctrine()->getManager()->getRepository(Cases::class);
		//$this->repoTranscripts = $this->getDoctrine()->getManager()->getRepository(Transcript::class);
		//la autentificacion de la API de chat se hace aqui.
		$this->HttpHeaderSnapchat[] = 'Accept: application/json';
		$this->HttpHeaderSnapchat[] = 'Content-Type: application/json';
		$this->HttpHeaderSnapchat[] = 'Content-length: 0';
		$this->HttpHeaderSnapchat[] = 'Authorization: ebec63f521baf484da13a550a111e5d6';
	}

	/**
	 * @param Request $request
	 *
	 * @return Response
	 *                  path : /SnapEngageChat/index
	 */
	public function indexAction(Request $request) {
		echo '$uri: ' . SNAPCHAT_URI . '<br>';
		echo '$uri: ' . var_dump($this->HttpHeaderSnapchat) . '<br>';

		//$ApiGatorSnapChat = new ApiGator(SNAPCHAT_URI, $this->httpHeaderSnapchat);
		$ApiGatorSnapChat = new ApiGator(SNAPCHAT_URI, $this->HttpHeaderSnapchat);

		//forsinnext.
		$NextUri = SNAPCHAT_URI;
		while (false != $NextUri) {
			$ApiGatorSnapChat->setUri($NextUri);
			$NextUri = $this->Persist100AndGetNextUri($ApiGatorSnapChat->getCurlResponse());
		}

		//NO ME BORRRES o renderiza , o mejor manda a alguien a renderizar...xd .
		return new Response(nl2br('Extracción de datos de Api Rest de SnapEngageChatController.
								
				                    Numero de Uris Procesadas (100 regs): ' . $this->CounterBloqueDatos100Registros . '
				                    Numero de Excepciones de Falta de indices: ' . $this->CounterIndexException . '
				                    Chats Leidos :  ' . $this->CounterChatsLeidos . '
									Chats Persistidos :' . $this->CounterCasosPersistidos . '
									Lineas Leidas :  ' . $this->CounterLineas . '
									'));
	}
	
	/**
	 * Procesa el json con la response de los cases.
	 * Por cada caso crea una entidad en el ORM.
	 *
	 * @warning NO HACE FLUSH!!
	 *
	 * @param json $json
	 *
	 * @return bool si quedan datos , la Uri , si ya no queda nada NULL
	 */
	private function Persist100AndGetNextUri($json) {
		//todo: sacar la load fuera y dejar solo la persist.
		//json2array
		$arr = json_decode($json, true);

		if (isset($arr['cases'])) {
			foreach ($arr['cases'] as $case) {
				++$this->CounterChatsLeidos;
				$this->PersistCase($case);
			}
		}

		//COUNTER
		$this->CounterBloqueDatos100Registros++;

		return isset($arr['linkToNextSetOfResults']) ? $arr['linkToNextSetOfResults'] : false;
	}

	/**
	 * @param type $Case
	 *
	 * @return bool
	 */
	private function existsCase($IdCase) {
		//Evita  \Doctrine\DBAL\Exception\UniqueConstraintViolationException
		$where = ['idCase' => $IdCase];

		return null != $this->getDoctrine()->getManager()->getRepository(Cases::class)->findBy($where) ? true : false;
	}

	public function loadAction(Request $request, $fechaDesde, $fechaHasta) {

		//TODO : COPIA DE LA INDEX PERO PARAMETRIZADA.
		//NO ME BORRRES o renderiza , o mejor manda a alguien a renderizar...xd .
		return new Response(nl2br('Extracción de datos de Api Rest de SnapEngageChatController.
									fecha desde:' . $fechaDesde . '
				                    Numero de Uris Procesadas: ' . $fechaHasta));
	}

	public function log($data) {
		if (is_array($data)) {
			$output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
		} else {
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		}

		echo $output;
	}

	public function existsTranscript($id) {
		//Evita  \Doctrine\DBAL\Exception\UniqueConstraintViolationException
		return null != $this->getDoctrine()->getManager()->getRepository(Transcript::class)->find($id) ? true : false;
	}

	/***
	 * Precondición , el $case está verificado . 
	 * Espera un array del tipo case. Lo carga en una nueva entidad y la 
	 * persiste , además flushea. 
	 * 
	 * @param array $case
	 * 
	 */
	public function PersistCase($case) {


		$caseToAdd = new Cases(); //buffer

		$caseToAdd->setIdCase($case['id']);
		$caseToAdd->setUrl($case['url']);
		$caseToAdd->setType($case['type']);
		$caseToAdd->setRequestedBy($case['requested_by']);
		if (isset($case['requester_details'])) {
			$caseToAdd->setRequesterDetails($case['requester_details']);
		}
		$caseToAdd->setDescription($case['description']);
		$caseToAdd->setCreatedAtDate($case['created_at_date']);
		$caseToAdd->setCreatedAtSeconds($case['created_at_seconds']);
		$caseToAdd->setCreatedAtMilliseconds($case['created_at_milliseconds']);
		$caseToAdd->setProactiveChat($case['proactive_chat']);
		$caseToAdd->setPageUrl($case['page_url']);
		if (isset($case['referrer_url'])) {
			$caseToAdd->setReferrerUrl($case['referrer_url']);
		}
		if (isset($case['entry_url'])) {
			$caseToAdd->setEntryUrl($case['entry_url']);
		}

		$caseToAdd->setIpAddress($case['ip_address']);
		//Se machaca abajo con el $user, aquí se setteaba.
		//$caseToAdd->setUserAgent($case['user_agent']); 
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
		$caseToAdd->setJavascriptVariables($case['javascript_variables']);
		//valoración.
		if (isset($case['survey_score'])) {
			$caseToAdd->setSurveyScore($case['survey_score']);
		}
		//todo: setsafe()
		if (isset($case['transcripts'])) {
			$caseToAdd->setTranscripts($case['transcripts']);

			//Extraemos de las lineas del chat el user, 
			//realmente es lo que nos interesa, no la linea en sí.
			foreach ($caseToAdd->getTranscripts() as $trasncript) {
				$this->CounterLineas++;
				$user = ("" != $trasncript['alias']) ? $trasncript['alias'] : $user;
				
				//ya no queremos persistirlas, pero iría aquí si
				//hiciera falta descomentar y depurar esa funcion.
				//$this->PersistTranscript($trasncript);
			}
			/*
			 * Aquí ya tenemos , el número de lineas de cada chat
			 * como el $user. Por el momento solo guardaremos el user
			 * No voy a implementar otro campo más en la entidad 
			 * que ya va sobrada de mierda, voy a machacar directamente
			 * el campo donde guarda el navegador desde el que se accede 
			 * para guardar nuestro operador.
			 */
			$caseToAdd->setUserAgent($user);
			
		}

		// _persist
		if (!$this->existsCase($caseToAdd->getIdCase())) {
			$this->getDoctrine()->getManager()->persist($caseToAdd);
			if ($this->getDoctrine()->getManager()->flush()) {
				dump('No se ha podido insertar el Case : ' . $caseToAdd);
			} else {
				++$this->CounterCasosPersistidos;
				var_dump('Insertando IdCase: ' . $caseToAdd->getIdCase());
			}
		} else {
			var_dump('El Caso: ' . $caseToAdd->getIdCase() . ' Ya existe.. se omite');
		}

		//COUNTER
		unset($caseToAdd);
	}

	/**
	 * Cuidado total , no usar sin revisar , este código funciona
	 * pero como ya no queremos las lineas no se ha depurado mucho.
	 * Esta función se queda historicamente para la versión beta.
	 * 
	 * @param array $trasncript 
	 */
	public function PersistTranscript($trasncript) {
		//GUARDA LINEA COMPLETA.
		$trasncript2add = new Transcript();
		++$this->CounterLineas;
		//cargamos
		$hash = hash('md5', $trasncript['id'] . $trasncript['date'] . $trasncript['date_seconds']);
		$trasncript2add->setIdTranscript($caseToAdd->getIdCase() . '_' . $trasncript['date_seconds']);
		$trasncript2add->setDate($trasncript['date']);
		$trasncript2add->setDateSeconds($trasncript['date_seconds']);
		$trasncript2add->setDateMiliseconds($trasncript['date_milliseconds']);
		$trasncript2add->setAlias($trasncript['alias']);
		$trasncript2add->setMessage($trasncript['message']);
		//la fk
		$trasncript2add->setIdCase($caseToAdd->getIdCase());
		//persistimos
		if (!$this->existsTranscript($trasncript2add->getIdTranscript())) {
			$this->getDoctrine()->getManager()->persist($trasncript2add);
			if ($this->getDoctrine()->getManager()->flush()) {
				var_dump('No se ha podido insertar la linea : ' . $trasncript2add);
			} else {
				++$this->CounterLineasPersistidas;
				var_dump('Insertando Linea: ' . $trasncript2add->getIdTranscript());
			}
		} else {
			var_dump('La linea : ' . $trasncript2add->getIdTranscript() . ' Ya existe.. se omite');
		}

		unset($trasncript2add);
	}

}
