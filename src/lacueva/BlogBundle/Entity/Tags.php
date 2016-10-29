<?php

namespace lacueva\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata ;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Tags
 */
class Tags  
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
	
  public static function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadatos)
  {
	  $metadatos->addPropertyConstraint("name", new \Symfony\Component\Validator\Constraints\NotBlank());
	   $metadatos->addPropertyConstraint("name",
			  new \Symfony\Component\Validator\Constraints\Length(
					  ["min" => 2, 
						  "minMessage" => "Una Tag no puede tener menos de {{ limit }}  Caracteres"
						  ]));
	 
	  $metadatos->addPropertyConstraint("description",
			  new \Symfony\Component\Validator\Constraints\Length(
					  ["min" => 5, 
						  "minMessage" => "La descripción debería de ser de al menos {{ limit }}  Caracteres"
						  ]));
	  
	  
  }

	/**
     * @var string
     */
    private $description;


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
     * Set name
     *
     * @param string $name
     *
     * @return Tags
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Tags
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
}
