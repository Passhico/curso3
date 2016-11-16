<?php

namespace lacueva\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cases
 *
 * @ORM\Table(name="cases")
 * @ORM\Entity(repositoryClass="lacueva\BlogBundle\Repository\casesRepository")
 */
class cases
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="requested_by", type="string", length=255)
     */
    private $requestedBy;

    /**
     * @var array
     *
     * @ORM\Column(name="requester_details", type="json_array")
     */
    private $requesterDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at_date", type="datetime")
     */
    private $createdAtDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at_seconds", type="datetime")
     */
    private $createdAtSeconds;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at_milliseconds", type="datetime")
     */
    private $createdAtMilliseconds;

    /**
     * @var bool
     *
     * @ORM\Column(name="proactive_chat", type="boolean")
     */
    private $proactiveChat;

    /**
     * @var string
     *
     * @ORM\Column(name="page_url", type="string", length=1000)
     */
    private $pageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="referrer_url", type="string", length=1000)
     */
    private $referrerUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="entry_url", type="string", length=1000)
     */
    private $entryUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="string", length=1000)
     */
    private $userAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=255)
     */
    private $browser;

    /**
     * @var string
     *
     * @ORM\Column(name="os", type="string", length=255)
     */
    private $os;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="source_id", type="integer")
     */
    private $sourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="chat_waittime", type="string", length=255)
     */
    private $chatWaittime;

    /**
     * @var int
     *
     * @ORM\Column(name="chat_duration", type="integer")
     */
    private $chatDuration;

    /**
     * @var int
     *
     * @ORM\Column(name="survey_score", type="integer")
     */
    private $surveyScore;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=255)
     */
    private $languageCode;

    /**
     * @var array
     *
     * @ORM\Column(name="transcripts", type="json_array")
     */
    private $transcripts;

    /**
     * @var array
     *
     * @ORM\Column(name="javascript_variables", type="json_array")
     */
    private $javascriptVariables;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return cases
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return cases
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set requestedBy
     *
     * @param string $requestedBy
     *
     * @return cases
     */
    public function setRequestedBy($requestedBy)
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    /**
     * Get requestedBy
     *
     * @return string
     */
    public function getRequestedBy()
    {
        return $this->requestedBy;
    }

    /**
     * Set requesterDetails
     *
     * @param array $requesterDetails
     *
     * @return cases
     */
    public function setRequesterDetails($requesterDetails)
    {
        $this->requesterDetails = $requesterDetails;

        return $this;
    }

    /**
     * Get requesterDetails
     *
     * @return array
     */
    public function getRequesterDetails()
    {
        return $this->requesterDetails;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return cases
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAtDate
     *
     * @param \DateTime $createdAtDate
     *
     * @return cases
     */
    public function setCreatedAtDate($createdAtDate)
    {
        $this->createdAtDate = $createdAtDate;

        return $this;
    }

    /**
     * Get createdAtDate
     *
     * @return \DateTime
     */
    public function getCreatedAtDate()
    {
        return $this->createdAtDate;
    }

    /**
     * Set createdAtSeconds
     *
     * @param \DateTime $createdAtSeconds
     *
     * @return cases
     */
    public function setCreatedAtSeconds($createdAtSeconds)
    {
        $this->createdAtSeconds = $createdAtSeconds;

        return $this;
    }

    /**
     * Get createdAtSeconds
     *
     * @return \DateTime
     */
    public function getCreatedAtSeconds()
    {
        return $this->createdAtSeconds;
    }

    /**
     * Set createdAtMilliseconds
     *
     * @param \DateTime $createdAtMilliseconds
     *
     * @return cases
     */
    public function setCreatedAtMilliseconds($createdAtMilliseconds)
    {
        $this->createdAtMilliseconds = $createdAtMilliseconds;

        return $this;
    }

    /**
     * Get createdAtMilliseconds
     *
     * @return \DateTime
     */
    public function getCreatedAtMilliseconds()
    {
        return $this->createdAtMilliseconds;
    }

    /**
     * Set proactiveChat
     *
     * @param boolean $proactiveChat
     *
     * @return cases
     */
    public function setProactiveChat($proactiveChat)
    {
        $this->proactiveChat = $proactiveChat;

        return $this;
    }

    /**
     * Get proactiveChat
     *
     * @return bool
     */
    public function getProactiveChat()
    {
        return $this->proactiveChat;
    }

    /**
     * Set pageUrl
     *
     * @param string $pageUrl
     *
     * @return cases
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * Get pageUrl
     *
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Set referrerUrl
     *
     * @param string $referrerUrl
     *
     * @return cases
     */
    public function setReferrerUrl($referrerUrl)
    {
        $this->referrerUrl = $referrerUrl;

        return $this;
    }

    /**
     * Get referrerUrl
     *
     * @return string
     */
    public function getReferrerUrl()
    {
        return $this->referrerUrl;
    }

    /**
     * Set entryUrl
     *
     * @param string $entryUrl
     *
     * @return cases
     */
    public function setEntryUrl($entryUrl)
    {
        $this->entryUrl = $entryUrl;

        return $this;
    }

    /**
     * Get entryUrl
     *
     * @return string
     */
    public function getEntryUrl()
    {
        return $this->entryUrl;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return cases
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return cases
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set browser
     *
     * @param string $browser
     *
     * @return cases
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set os
     *
     * @param string $os
     *
     * @return cases
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Get os
     *
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return cases
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return cases
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return cases
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return cases
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return cases
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return cases
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set sourceId
     *
     * @param integer $sourceId
     *
     * @return cases
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set chatWaittime
     *
     * @param string $chatWaittime
     *
     * @return cases
     */
    public function setChatWaittime($chatWaittime)
    {
        $this->chatWaittime = $chatWaittime;

        return $this;
    }

    /**
     * Get chatWaittime
     *
     * @return string
     */
    public function getChatWaittime()
    {
        return $this->chatWaittime;
    }

    /**
     * Set chatDuration
     *
     * @param integer $chatDuration
     *
     * @return cases
     */
    public function setChatDuration($chatDuration)
    {
        $this->chatDuration = $chatDuration;

        return $this;
    }

    /**
     * Get chatDuration
     *
     * @return int
     */
    public function getChatDuration()
    {
        return $this->chatDuration;
    }

    /**
     * Set surveyScore
     *
     * @param integer $surveyScore
     *
     * @return cases
     */
    public function setSurveyScore($surveyScore)
    {
        $this->surveyScore = $surveyScore;

        return $this;
    }

    /**
     * Get surveyScore
     *
     * @return int
     */
    public function getSurveyScore()
    {
        return $this->surveyScore;
    }

    /**
     * Set languageCode
     *
     * @param string $languageCode
     *
     * @return cases
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * Get languageCode
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * Set transcripts
     *
     * @param array $transcripts
     *
     * @return cases
     */
    public function setTranscripts($transcripts)
    {
        $this->transcripts = $transcripts;

        return $this;
    }

    /**
     * Get transcripts
     *
     * @return array
     */
    public function getTranscripts()
    {
        return $this->transcripts;
    }

    /**
     * Set javascriptVariables
     *
     * @param array $javascriptVariables
     *
     * @return cases
     */
    public function setJavascriptVariables($javascriptVariables)
    {
        $this->javascriptVariables = $javascriptVariables;

        return $this;
    }

    /**
     * Get javascriptVariables
     *
     * @return array
     */
    public function getJavascriptVariables()
    {
        return $this->javascriptVariables;
    }
}

