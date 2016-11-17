<?php

namespace lacueva\BlogBundle\Entity;

/**
 * Cases
 */
class Cases {

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $idCase;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var array
	 */
	private $requestedBy;

	/**
	 * @var array
	 */
	private $requesterDetails;

	/**
	 * @var float
	 */
	private $createdAtDate;

	/**
	 * @var int
	 */
	private $createdAtSeconds;

	/**
	 * @var int
	 */
	private $createdAtMilliseconds;

	/**
	 * @var bool
	 */
	private $proactiveChat;

	/**
	 * @var string
	 */
	private $pageUrl;

	/**
	 * @var string
	 */
	private $referrerUrl;

	/**
	 * @var string
	 */
	private $entryUrl;

	/**
	 * @var string
	 */
	private $ipAddress;

	/**
	 * @var string
	 */
	private $userAgent;

	/**
	 * @var string
	 */
	private $browser;

	/**
	 * @var string
	 */
	private $os;

	/**
	 * @var string
	 */
	private $countryCode;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $region;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var float
	 */
	private $latitude;

	/**
	 * @var float
	 */
	private $longitude;

	/**
	 * @var int
	 */
	private $sourceId;

	/**
	 * @var int
	 */
	private $chatWaittime;

	/**
	 * @var int
	 */
	private $chatDuration;

	/**
	 * @var int
	 */
	private $surveyScore;

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var array
	 */
	private $transcripts;

	/**
	 * @var array
	 */
	private $javascriptVariables;

	/**
	 * @var string
	 */
	private $description;

	function getDescription() {
		return $this->description;
	}

	function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set idCase
	 *
	 * @param string $idCase
	 *
	 * @return Cases
	 */
	public function setIdCase($idCase) {
		$this->idCase = $idCase;

		return $this;
	}

	/**
	 * Get idCase
	 *
	 * @return string
	 */
	public function getIdCase() {
		return $this->idCase;
	}

	/**
	 * Set url
	 *
	 * @param string $url
	 *
	 * @return Cases
	 */
	public function setUrl($url) {
		$this->url = $url;

		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Set type
	 *
	 * @param string $type
	 *
	 * @return Cases
	 */
	public function setType($type) {
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set requestedBy
	 *
	 * @param array $requestedBy
	 *
	 * @return Cases
	 */
	public function setRequestedBy($requestedBy) {
		$this->requestedBy = $requestedBy;

		return $this;
	}

	/**
	 * Get requestedBy
	 *
	 * @return array
	 */
	public function getRequestedBy() {
		return $this->requestedBy;
	}

	/**
	 * Set requesterDetails
	 *
	 * @param array $requesterDetails
	 *
	 * @return Cases
	 */
	public function setRequesterDetails($requesterDetails) {
		$this->requesterDetails = $requesterDetails;

		return $this;
	}

	/**
	 * Get requesterDetails
	 *
	 * @return array
	 */
	public function getRequesterDetails() {
		return $this->requesterDetails;
	}

	/**
	 * Set createdAtDate
	 *
	 * @param float $createdAtDate
	 *
	 * @return Cases
	 */
	public function setCreatedAtDate($createdAtDate) {
		$this->createdAtDate = $createdAtDate;

		return $this;
	}

	/**
	 * Get createdAtDate
	 *
	 * @return float
	 */
	public function getCreatedAtDate() {
		return $this->createdAtDate;
	}

	/**
	 * Set createdAtSeconds
	 *
	 * @param integer $createdAtSeconds
	 *
	 * @return Cases
	 */
	public function setCreatedAtSeconds($createdAtSeconds) {
		$this->createdAtSeconds = $createdAtSeconds;

		return $this;
	}

	/**
	 * Get createdAtSeconds
	 *
	 * @return int
	 */
	public function getCreatedAtSeconds() {
		return $this->createdAtSeconds;
	}

	/**
	 * Set createdAtMilliseconds
	 *
	 * @param integer $createdAtMilliseconds
	 *
	 * @return Cases
	 */
	public function setCreatedAtMilliseconds($createdAtMilliseconds) {
		$this->createdAtMilliseconds = $createdAtMilliseconds;

		return $this;
	}

	/**
	 * Get createdAtMilliseconds
	 *
	 * @return int
	 */
	public function getCreatedAtMilliseconds() {
		return $this->createdAtMilliseconds;
	}

	/**
	 * Set proactiveChat
	 *
	 * @param boolean $proactiveChat
	 *
	 * @return Cases
	 */
	public function setProactiveChat($proactiveChat) {
		$this->proactiveChat = $proactiveChat;

		return $this;
	}

	/**
	 * Get proactiveChat
	 *
	 * @return bool
	 */
	public function getProactiveChat() {
		return $this->proactiveChat;
	}

	/**
	 * Set pageUrl
	 *
	 * @param string $pageUrl
	 *
	 * @return Cases
	 */
	public function setPageUrl($pageUrl) {
		$this->pageUrl = $pageUrl;

		return $this;
	}

	/**
	 * Get pageUrl
	 *
	 * @return string
	 */
	public function getPageUrl() {
		return $this->pageUrl;
	}

	/**
	 * Set referrerUrl
	 *
	 * @param string $referrerUrl
	 *
	 * @return Cases
	 */
	public function setReferrerUrl($referrerUrl) {
		$this->referrerUrl = $referrerUrl;

		return $this;
	}

	/**
	 * Get referrerUrl
	 *
	 * @return string
	 */
	public function getReferrerUrl() {
		return $this->referrerUrl;
	}

	/**
	 * Set entryUrl
	 *
	 * @param string $entryUrl
	 *
	 * @return Cases
	 */
	public function setEntryUrl($entryUrl) {
		$this->entryUrl = $entryUrl;

		return $this;
	}

	/**
	 * Get entryUrl
	 *
	 * @return string
	 */
	public function getEntryUrl() {
		return $this->entryUrl;
	}

	/**
	 * Set ipAddress
	 *
	 * @param string $ipAddress
	 *
	 * @return Cases
	 */
	public function setIpAddress($ipAddress) {
		$this->ipAddress = $ipAddress;

		return $this;
	}

	/**
	 * Get ipAddress
	 *
	 * @return string
	 */
	public function getIpAddress() {
		return $this->ipAddress;
	}

	/**
	 * Set userAgent
	 *
	 * @param string $userAgent
	 *
	 * @return Cases
	 */
	public function setUserAgent($userAgent) {
		$this->userAgent = $userAgent;

		return $this;
	}

	/**
	 * Get userAgent
	 *
	 * @return string
	 */
	public function getUserAgent() {
		return $this->userAgent;
	}

	/**
	 * Set browser
	 *
	 * @param string $browser
	 *
	 * @return Cases
	 */
	public function setBrowser($browser) {
		$this->browser = $browser;

		return $this;
	}

	/**
	 * Get browser
	 *
	 * @return string
	 */
	public function getBrowser() {
		return $this->browser;
	}

	/**
	 * Set os
	 *
	 * @param string $os
	 *
	 * @return Cases
	 */
	public function setOs($os) {
		$this->os = $os;

		return $this;
	}

	/**
	 * Get os
	 *
	 * @return string
	 */
	public function getOs() {
		return $this->os;
	}

	/**
	 * Set countryCode
	 *
	 * @param string $countryCode
	 *
	 * @return Cases
	 */
	public function setCountryCode($countryCode) {
		$this->countryCode = $countryCode;

		return $this;
	}

	/**
	 * Get countryCode
	 *
	 * @return string
	 */
	public function getCountryCode() {
		return $this->countryCode;
	}

	/**
	 * Set country
	 *
	 * @param string $country
	 *
	 * @return Cases
	 */
	public function setCountry($country) {
		$this->country = $country;

		return $this;
	}

	/**
	 * Get country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Set region
	 *
	 * @param string $region
	 *
	 * @return Cases
	 */
	public function setRegion($region) {
		$this->region = $region;

		return $this;
	}

	/**
	 * Get region
	 *
	 * @return string
	 */
	public function getRegion() {
		return $this->region;
	}

	/**
	 * Set city
	 *
	 * @param string $city
	 *
	 * @return Cases
	 */
	public function setCity($city) {
		$this->city = $city;

		return $this;
	}

	/**
	 * Get city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Set latitude
	 *
	 * @param float $latitude
	 *
	 * @return Cases
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;

		return $this;
	}

	/**
	 * Get latitude
	 *
	 * @return float
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Set longitude
	 *
	 * @param float $longitude
	 *
	 * @return Cases
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;

		return $this;
	}

	/**
	 * Get longitude
	 *
	 * @return float
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Set sourceId
	 *
	 * @param integer $sourceId
	 *
	 * @return Cases
	 */
	public function setSourceId($sourceId) {
		$this->sourceId = $sourceId;

		return $this;
	}

	/**
	 * Get sourceId
	 *
	 * @return int
	 */
	public function getSourceId() {
		return $this->sourceId;
	}

	/**
	 * Set chatWaittime
	 *
	 * @param integer $chatWaittime
	 *
	 * @return Cases
	 */
	public function setChatWaittime($chatWaittime) {
		$this->chatWaittime = $chatWaittime;

		return $this;
	}

	/**
	 * Get chatWaittime
	 *
	 * @return int
	 */
	public function getChatWaittime() {
		return $this->chatWaittime;
	}

	/**
	 * Set chatDuration
	 *
	 * @param integer $chatDuration
	 *
	 * @return Cases
	 */
	public function setChatDuration($chatDuration) {
		$this->chatDuration = $chatDuration;

		return $this;
	}

	/**
	 * Get chatDuration
	 *
	 * @return int
	 */
	public function getChatDuration() {
		return $this->chatDuration;
	}

	/**
	 * Set surveyScore
	 *
	 * @param integer $surveyScore
	 *
	 * @return Cases
	 */
	public function setSurveyScore($surveyScore) {
		$this->surveyScore = $surveyScore;

		return $this;
	}

	/**
	 * Get surveyScore
	 *
	 * @return int
	 */
	public function getSurveyScore() {
		return $this->surveyScore;
	}

	/**
	 * Set languageCode
	 *
	 * @param string $languageCode
	 *
	 * @return Cases
	 */
	public function setLanguageCode($languageCode) {
		$this->languageCode = $languageCode;

		return $this;
	}

	/**
	 * Get languageCode
	 *
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * Set transcripts
	 *
	 * @param array $transcripts
	 *
	 * @return Cases
	 */
	public function setTranscripts($transcripts) {
		$this->transcripts = $transcripts;

		return $this;
	}

	/**
	 * Get transcripts
	 *
	 * @return array
	 */
	public function getTranscripts() {
		return $this->transcripts;
	}

	/**
	 * Set javascriptVariables
	 *
	 * @param array $javascriptVariables
	 *
	 * @return Cases
	 */
	public function setJavascriptVariables($javascriptVariables) {
		$this->javascriptVariables = $javascriptVariables;

		return $this;
	}

	/**
	 * Get javascriptVariables
	 *
	 * @return array
	 */
	public function getJavascriptVariables() {
		return $this->javascriptVariables;
	}

}
