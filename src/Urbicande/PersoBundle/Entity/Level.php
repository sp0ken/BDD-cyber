<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\PersoBundle\Entity\Level
 * @ORM\Table(name="cyber_Level")
 * @Gedmo\Loggable
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\LevelRepository")
 */
class Level
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var  ArrayCollection \Urbicande\PersoBundle\Entity\Personnage $players
     * Les personnages de ce niveau
     *
     * @ORM\OneToMany(targetEntity="\Urbicande\PersoBundle\Entity\Personnage", mappedBy="level")
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
     * @return Level
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
     * @return Level
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
     * Set level
     *
     * @param integer $level
     * @return Level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add player
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $player
     * @return Level
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

    public function __toString()
    {
        return $this->name.' (niveau '.$this->level.')';
    }
}