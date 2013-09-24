<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\PersoBundle\Entity\PersonnageType
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_PersonnageType")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\PersonnageTypeRepository")
 */
class PersonnageType
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     * Le nom du type de personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La description du type de personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var  ArrayCollection \Urbicande\PersoBundle\Entity\Personnage $players
     * Les personnages de ce type
     * 
     * @ORM\OneToMany(targetEntity="\Urbicande\PersoBundle\Entity\Personnage", mappedBy="type")
     **/
    private $players;

    public function __construct() {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Type
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
     * @return Type
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add player
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $player
     * @return PersonnageType
     */
    public function addPlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {
        $this->players[] = $player;
    
        return $this;
    }

    /**
     * Remove player
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $player
     */
    public function removePlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
}