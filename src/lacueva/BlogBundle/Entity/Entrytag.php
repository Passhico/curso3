<?php

namespace lacueva\BlogBundle\Entity;

/**
 * Entrytag
 */
class Entrytag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \lacueva\BlogBundle\Entity\Tags
     */
    private $idTag;

    /**
     * @var \lacueva\BlogBundle\Entity\Entries
     */
    private $idEntry;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idTag
     *
     * @param \lacueva\BlogBundle\Entity\Tags $idTag
     *
     * @return Entrytag
     */
    public function setIdTag(\lacueva\BlogBundle\Entity\Tags $idTag = null)
    {
        $this->idTag = $idTag;

        return $this;
    }

    /**
     * Get idTag
     *
     * @return \lacueva\BlogBundle\Entity\Tags
     */
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * Set idEntry
     *
     * @param \lacueva\BlogBundle\Entity\Entries $idEntry
     *
     * @return Entrytag
     */
    public function setIdEntry(\lacueva\BlogBundle\Entity\Entries $idEntry = null)
    {
        $this->idEntry = $idEntry;

        return $this;
    }

    /**
     * Get idEntry
     *
     * @return \lacueva\BlogBundle\Entity\Entries
     */
    public function getIdEntry()
    {
        return $this->idEntry;
    }
}

