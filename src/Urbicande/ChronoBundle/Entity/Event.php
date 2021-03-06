<?php

namespace Urbicande\ChronoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Évènement fictif du passé/présent/futur du background du jeu
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Event")
 * @ORM\Entity(repositoryClass="Urbicande\ChronoBundle\Entity\EventRepository")
 */
class Event
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
     * Le nom de l'évènement
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * la description de l'évènment
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime $start_date
     * La date de début
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="start_date", type="date")
     */
    private $start_date;

     /**
     * @var \DateTime $end_date
     * La date, optionnelle, de fin
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $end_date;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Personnage $players
     * Les personnages ayant participé à l'évènement
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Personnage", inversedBy="events", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_personnage_event")
     */
    private $players;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Groupe $groupes
     * Les groupes ayant participé à l'évènement
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Groupe", inversedBy="events", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_groupe_event")
     */
    private $groupes;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Intrigue $intrigues
     * Les intrigues liées à l'évènement
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="events", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_intrigue_event")
     */
    private $intrigues;

    /**
     * @var Urbicande\IntrigueBundle\Entity\Implication $implication
     * Les implications dans des intrigues
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Implication", mappedBy="event", cascade={"persist"})
     */
    private $implications;

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
     * @return Event
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
     * @return Event
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
     * Constructor
     */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intrigues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    
        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;
    
        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Add player
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $player
     * @return Event
     */
    public function addPlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {
        $this->players[] = $player;
    
        return $this;
    }

    /**
     * Remove player
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $player
     */
    public function removePlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Add groupe
     *
     * @param \Urbicande\PersoBundle\Entity\Groupe $groupe
     * @return Event
     */
    public function addGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;
    
        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \Urbicande\PersoBundle\Entity\Groupe $groupe
     */
    public function removeGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }

    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Add intrigue
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Event
     */
    public function addIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigues[] = $intrigue;
    
        return $this;
    }

    /**
     * Remove intrigue
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigues->removeElement($intrigue);
    }

    /**
     * Get intrigues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntrigues()
    {
        return $this->intrigues;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add implications
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $implications
     * @return Event
     */
    public function addImplication(\Urbicande\IntrigueBundle\Entity\Implication $implications)
    {
        $this->implications[] = $implications;
    
        return $this;
    }

    /**
     * Remove implications
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $implications
     */
    public function removeImplication(\Urbicande\IntrigueBundle\Entity\Implication $implications)
    {
        $this->implications->removeElement($implications);
    }

    /**
     * Get implications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImplications()
    {
        return $this->implications;
    }
}