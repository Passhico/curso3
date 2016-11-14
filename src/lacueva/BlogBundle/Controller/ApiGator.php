<?php

/**
 * Crea una Conexión con curl.php a una API rest, tras ello pone a 
 * disposición del usuario , tanto la response como un método específico
 * para procesarla según se prefiera.
 */

namespace ApiGator;

define('SECTION_CONVERSACIONES', "conversations");
define('SECTION_STATUS', "application/status");
define('SECTION_COMPANIAS	', "companies");

/**
 * 
 * 
 * @author Pascual Muñoz <pascual.munoz@pccomponentes.com>
 * @see https://support.ladesk.com/840770-Complete-API-reference#apiv1_agents
 * 
 */
class ApiGator {

	/**
	 * @var resource
	 * @see http://php.net/manual/es/resource.php
	 */
	public $ch;
	public $curl_response;


	/* Con estas 4 tenemos que formar la URI
	 * FORMATO de ejemplo:
	 * http://exp.com/api/conversations?&apikey=value
	 * se encarga generateUri()
	 * */
	private $url;
	private $section;
	private $apikey;
	private $request_parameters;
	private $uri;

	/**
	 * 
	 * @param SeccionDeLaApi $section 
	 * @param URL $url
	 * @param string $apikey
	 */
	public function __construct($section = "application/status", $url = 'https://express51.ladesk.com/api/', $apikey = '&apikey=10c54076befac3d7ba249637b9ee6a31', $request_parameters = []) {

		$this->url = $url;
		$this->apikey = $apikey;
		$this->section = $section;
		$this->request_parameters = $request_parameters;


		//Generamos la URI e iniciamos curl. cargamos ch 
		echo "Obteniendo: " . ($this->ch = curl_init($this->generateUri()) ) . PHP_EOL;

		//seteamos la opción especial.
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		//obtenemos response .
		$this->curl_response = curl_exec($this->ch);
		if ($this->curl_response === false) {
			$info = curl_error($this->ch);
			curl_close($this->ch) && die("Error en curl_exec(): " . var_export($info));
		}
	}

	private function generateUri() {

		$this->uri = $this->url . $this->section . '?' . $this->apikey;

		foreach ($this->request_parameters as $parametro) {
			$this->uri .= '&' . $parametro;
		}

		echo "<BR>URI: " . $this->uri;
		return $this->uri;
	}

	public function __destruct() {
		curl_close($this->ch);
	}

	/**
	 * 
	 * @param function $f Donde $f es una función f( json_decode(response) )
	 * 
	 */
	public function procesaResponseCon($f = 'print_r') {
		$f($this->curl_response);
	}

	/**
	 * Es solo un alias de procesaResponseCon()
	 * para tener una salida directa a terminal 
	 * por defecto.
	 */
	public function procesaResponse() {
		$this->procesaResponseCon();
	}

}
