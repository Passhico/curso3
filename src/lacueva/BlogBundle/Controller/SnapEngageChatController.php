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

define('SNAPCHAT_URI', SNAPCHAT_URL . SNAPCHAT_ORG_ID . '/logs?widgetId=' . SNAPCHAT_WIDGET_ID . '&start=2016-11-25&end=2016-11-26');
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
	private $CounterLineas;
	private $CounterChatsLeidos;
	private $CounterLineasPersistidas;

	/**
	 * Counter para saber cuantos casos no podemos persistir por culpa 
	 * de la falta de algunos indices. 
	 * @var int
	 */
	private $counterExcepcionesPorFaltaDeIndices;

	/*	 * ***************************************************************** */

	public function __construct() {

		//http://us2.php.net/manual/en/function.set-time-limit.php
		set_time_limit(3600); //elimina limintación de 60 segundos , mejor 1 hora.

		$this->CounterBloqueDatos100Registros = 0;
		$this->CounterCasosPersistidos = 0;

		$this->CounterLineas = 0;
		$this->CounterLineasPersistidas = 0;
		$this->CounterChatsLeidos = 0;

		//Cuando falla el persist de los cases.
		$this->counterExcepcionesPorFaltaDeIndices = 0;

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
				                    Chats Leidos :  ' . $this->CounterChatsLeidos . '
									Chats Persistidos :' . $this->CounterCasosPersistidos . '
									Chats Perdidos por falta de algun indice :' . $this->counterExcepcionesPorFaltaDeIndices . '
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

				//siempre puede que en el json falte algún indice 
				try {
					$this->PersistCase($case);
				} catch (\Symfony\Component\Debug\Exception\ContextErrorException $exc) {
					var_dump('Faltó un índice por ahí, pero da igual, ignoramos esta excepción y continuamos persistiendo' . $exc);
					$this->counterExcepcionesPorFaltaDeIndices++;
					continue;
				}
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

	/*	 * *
	 * Precondición , el $case está verificado . 
	 * Espera un array del tipo case. Lo carga en una nueva entidad y la 
	 * persiste , además flushea. 
	 * 
	 * @param array $case
	 * 
	 */

	public function PersistCase($case) {


		$case2add = new Cases(); //buffer
		//trabajo de chinos, y mira que lo he intentado XD
		if (isset($case['id'])) {
			$case2add->setIdCase($case['id']);
		}
		if (isset($case['url'])) {
			$case2add->setUrl($case['url']);
		}
		if (isset($case['type'])) {
			$case2add->setType($case['type']);
		}
		if (isset($case['requested_by'])) {
			$case2add->setRequestedBy($case['requested_by']);
		}
		if (isset($case['requester_details'])) {
			$case2add->setRequesterDetails($case['requester_details']);
		}
		if (isset($case['description'])) {
			$case2add->setDescription($case['description']);
		}
		if (isset($case['created_at_date'])) {
			$case2add->setCreatedAtDate($case['created_at_date']);
		}
		if (isset($case['created_at_seconds'])) {
			$case2add->setCreatedAtSeconds($case['created_at_seconds']);
		}
		if (isset($case['created_at_milliseconds'])) {
			$case2add->setCreatedAtMilliseconds($case['created_at_milliseconds']);
		}
		if (isset($case['proactive_chat'])) {
			$case2add->setProactiveChat($case['proactive_chat']);
		}
		if (isset($case['page_url'])) {
			$case2add->setPageUrl($case['page_url']);
		}
		if (isset($case['referrer_url'])) {
			$case2add->setReferrerUrl($case['referrer_url']);
		}
		if (isset($case['entry_url'])) {
			$case2add->setEntryUrl($case['entry_url']);
		}
		if (isset($case['ip_address'])) {
			$case2add->setIpAddress($case['ip_address']);
		}
		if (isset($case['browser'])) {
			$case2add->setBrowser($case['browser']);
		}
		if (isset($case['os'])) {
			$case2add->setOs($case['os']);
		}
		if (isset($case['country_code'])) {
			$case2add->setCountryCode($case['country_code']);
		}
		if (isset($case['country'])) {
			$case2add->setCountry($case['country']);
		}
		if (isset($case['region'])) {
			$case2add->setRegion($case['region']);
		}
		if (isset($case['city'])) {
			$case2add->setCity($case['city']);
		}
		if (isset($case['latitude'])) {
			$case2add->setLatitude($case['latitude']);
		}
		if (isset($case['longitude'])) {
			$case2add->setLongitude($case['longitude']);
		}
		if (isset($case['source_id'])) {
			$case2add->setSourceId($case['source_id']);
		}
		if (isset($case['chat_waittime'])) {
			$case2add->setChatWaittime($case['chat_waittime']);
		}

		$case2add->setChatDuration($case['chat_duration']);
		$case2add->setLanguageCode($case['language_code']);
		$case2add->setJavascriptVariables($case['javascript_variables']);
		//valoración.
		if (isset($case['survey_score'])) {
			$case2add->setSurveyScore($case['survey_score']);
		}
		//todo: setsafe()
		if (isset($case['transcripts'])) {
			$case2add->setTranscripts($case['transcripts']);

			//Extraemos de las lineas del chat el user, 
			//realmente es lo que nos interesa, no la linea en sí si no el ...
			$user = "";
			foreach ($case2add->getTranscripts() as $trasncript) {
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
			$case2add->setUserAgent($user);
		}

		// _persist
		if (!$this->existsCase($case2add->getIdCase())) {
			$this->getDoctrine()->getManager()->persist($case2add);
			if ($this->getDoctrine()->getManager()->flush()) {
				dump('No se ha podido insertar el Case : ' . $case2add);
			} else {
				++$this->CounterCasosPersistidos;
				var_dump('Insertando IdCase: ' . $case2add->getIdCase());
			}
		} else {
			var_dump('El Caso: ' . $case2add->getIdCase() . ' Ya existe.. se omite');
		}

		//COUNTER
		unset($case2add);
	}

	/**
	 * Cuidado total , no usar sin revisar , este código funciona
	 * pero como ya no queremos las lineas no se ha depurado mucho.
	 * Esta función se queda historicamente para la versión beta.
	 * 
	 * @param array $trasncript 
	 */
	public function PersistTranscript($trasncript, $acseToAdd) {
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
