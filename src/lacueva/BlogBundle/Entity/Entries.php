<?php

namespace lacueva\BlogBundle\Entity;

/**
 * Entries
 */
class Entries
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $entryTag;

    /**
     * @var \lacueva\BlogBundle\Entity\Users
     */
    private $idUser;

    /**
     * @var \lacueva\BlogBundle\Entity\Categories
     */
    private $idCategory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entryTag = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Entries
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Entries
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Entries
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Entries
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add entryTag
     *
     * @param \lacueva\BlogBundle\Entity\Entrytag $entryTag
     *
     * @return Entries
     */
    public function addEntryTag(\lacueva\BlogBundle\Entity\Entrytag $entryTag)
    {
        $this->entryTag[] = $entryTag;

        return $this;
    }

    /**
     * Remove entryTag
     *
     * @param \lacueva\BlogBundle\Entity\Entrytag $entryTag
     */
    public function removeEntryTag(\lacueva\BlogBundle\Entity\Entrytag $entryTag)
    {
        $this->entryTag->removeElement($entryTag);
    }

    /**
     * Get entryTag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntryTag()
    {
        return $this->entryTag;
    }

    /**
     * Set idUser
     *
     * @param \lacueva\BlogBundle\Entity\Users $idUser
     *
     * @return Entries
     */
    public function setIdUser(\lacueva\BlogBundle\Entity\Users $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \lacueva\BlogBundle\Entity\Users
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idCategory
     *
     * @param \lacueva\BlogBundle\Entity\Categories $idCategory
     *
     * @return Entries
     */
    public function setIdCategory(\lacueva\BlogBundle\Entity\Categories $idCategory = null)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return \lacueva\BlogBundle\Entity\Categories
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }
}

