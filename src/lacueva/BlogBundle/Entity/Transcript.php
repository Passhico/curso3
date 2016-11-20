<?php

namespace lacueva\BlogBundle\Entity;

/**
 * Transcript
 */
class Transcript
{
    /**
     * @var int
     */
    private $id;
	
	 /**
     * @var int
     */
	private $idCase; 
	public function getIdCase() {
		return $this->idCase;
	}

	public function setIdCase($idCase) {
		$this->idCase = $idCase;
	}

	    /**
     * @var string
     */
    private $idTranscript;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $dateSeconds;

    /**
     * @var int
     */
    private $dateMiliseconds;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $message;


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
     * Set idTranscript
     *
     * @param string $idTranscript
     *
     * @return Transcript
     */
    public function setIdTranscript($idTranscript)
    {
        $this->idTranscript = $idTranscript;

        return $this;
    }

    /**
     * Get idTranscript
     *
     * @return string
     */
    public function getIdTranscript()
    {
        return $this->idTranscript;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Transcript
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateSeconds
     *
     * @param \DateTime $dateSeconds
     *
     * @return Transcript
     */
    public function setDateSeconds($dateSeconds)
    {
        $this->dateSeconds = $dateSeconds;

        return $this;
    }

    /**
     * Get dateSeconds
     *
     * @return \DateTime
     */
    public function getDateSeconds()
    {
        return $this->dateSeconds;
    }

    /**
     * Set dateMiliseconds
     *
     * @param integer $dateMiliseconds
     *
     * @return Transcript
     */
    public function setDateMiliseconds($dateMiliseconds)
    {
        $this->dateMiliseconds = $dateMiliseconds;

        return $this;
    }

    /**
     * Get dateMiliseconds
     *
     * @return int
     */
    public function getDateMiliseconds()
    {
        return $this->dateMiliseconds;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Transcript
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Transcript
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }



}

