<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Détails d'une implication d'un personnage/groupe/évènement dans une intrigue
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Implication")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\ImplicationRepository")
 */
class Implication
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
     * @var Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * Intrigue de l'implication
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="implications", cascade={"persist"})
     */
    private $intrigue;

    /**
     * @var Urbicande\PersoBundle\Entity\Personnage $player
     * Personnage de l'implication
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\Personnage", inversedBy="intrigues", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $player;

    /**
     * @var Urbicande\ChronoBundle\Entity\Event $event
     * Évènement de l'implication
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\ChronoBundle\Entity\Event", inversedBy="implications", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $event;

    /**
     * @var Urbicande\PersoBundle\Entity\Groupe $groupe
     * Groupe de l'implication
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\Groupe", inversedBy="intrigues", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $groupe;

    /**
     * @var string $degree
     * Degrés de l'implication (à customiser dans ../Form/ImplicationType.php)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="degree", type="string", length=255, nullable=true)
     */
    private $degree;

    /**
     * @var string $synopsis
     * Synopsis de l'implication
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="synopsis", type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @var string $theme
     * Theme(s) de l'implication
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @var string $description
     * Description de l'implication (pour le rédacteur)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $information
     * Informations de l'implication (pour le personnage)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="information", type="text", nullable=true)
     */
    private $information;

    /**
     * @var string $objective
     * Objectifs de l'implication
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="objective", type="text", nullable=true)
     */
    private $objective;


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
     * Set degree
     *
     * @param string $degree
     * @return Implication
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    
        return $this;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set synopsis
     *
     * @param \stdClass $synopsis
     * @return Implication
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    
        return $this;
    }

    /**
     * Get synopsis
     *
     * @return \stdClass 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Implication
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    
        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Implication
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
     * Set information
     *
     * @param string $information
     * @return Implication
     */
    public function setInformation($information)
    {
        $this->information = $information;
    
        return $this;
    }

    /**
     * Get information
     *
     * @return string 
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set objective
     *
     * @param string $objective
     * @return Implication
     */
    public function setObjective($objective)
    {
        $this->objective = $objective;
    
        return $this;
    }

    /**
     * Get objective
     *
     * @return string 
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * Set intrigue
     *
     * @param Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Implication
     */
    public function setIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigue = $intrigue;
    
        return $this;
    }

    /**
     * Get intrigue
     *
     * @return Urbicande\IntrigueBundle\Entity\Intrigue 
     */
    public function getIntrigue()
    {
        return $this->intrigue;
    }

    /**
     * Set player
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $player
     * @return Implication
     */
    public function setPlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {
        $this->player = $player;
    
        return $this;
    }

    /**
     * Get player
     *
     * @return Urbicande\PersoBundle\Entity\Personnage 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set groupe
     *
     * @param \Urbicande\PersoBundle\Entity\Groupe $groupe
     * @return Implication
     */
    public function setGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;
    
        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Urbicande\PersoBundle\Entity\Groupe 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Overrides default toString behaviour
     */
    public function __toString()
    {
        if(isset($this->player)) {
            return 'Implication de '.$this->player;
        } elseif (isset($this->groupe)) {
            return 'Implication du groupe "'.$this->groupe.'"';
        } elseif(isset($this->event)) {
            return 'Implication pour l‘évènement "'.$this->event.'"';
        } else {
            return 'Implication de on-ne-sait-pas-trop-qui';
        }
    }

    /**
     * Set event
     *
     * @param \Urbicande\ChronoBundle\Entity\Event $event
     * @return Implication
     */
    public function setEvent(\Urbicande\ChronoBundle\Entity\Event $event = null)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return \Urbicande\ChronoBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}