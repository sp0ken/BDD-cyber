<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Intrigue
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Intrigue")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\IntrigueRepository")
 */
class Intrigue
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
     * @var Urbicande\UserBundle\Entity\User $writer
     * Scénariste référent
     *
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="intrigues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var string $name
     * Nom
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer $number
     * Le numéro, attribué par l'équipe, de l'intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * @var string $status
     * Statut de l'écriture 
     * A customiser dans ../Form/IntrigueType.php, app/config/parameters.yml et app/config/config.yml
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var  Urbicande\IntrigueBundle\Entity\IntrigueType $type
     * Type de l'intrigue
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\IntrigueType", inversedBy="intrigues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var Urbicande\IntrigueBundle\Entity\Synopsis $synopsis
     * Synopsis
     *
     * @ORM\OneToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Synopsis", inversedBy="intrigue", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $synopsis;

    /**
     * @var Urbicande\IntrigueBundle\Entity\Plot $plot
     * Détails de l'intrigue
     * 
     * @ORM\OneToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Plot", inversedBy="intrigue", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $plot;

    /**
     * Objets liés à l'intrigue
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Object", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_intrigue_object")
     */
    private $objects;

    /**
     * Régles spécifiques à cette intrigue
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Rule", mappedBy="intrigue", cascade={"persist", "remove"})
     */
    private $rules;

    /**
     * Implications dans cette intrigue
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Implication", mappedBy="intrigue", cascade={"persist", "remove"})
     */
    private $implications;

    /**
     * @var ArrayCollection Urbicande\ChronoBundle\Entity\Event $events
     * Les évènements liés à cette intrigue
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\ChronoBundle\Entity\Event", mappedBy="intrigues", cascade={"persist"})
     */
    private $events;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Skill $skills
     * Les compétences nécessaire à cette intrigue
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Skill", mappedBy="intrigues", cascade={"persist"})
     */
    private $skills;

     /**
     * @var  ArrayCollection Urbicande\IntrigueBundle\Entity\IntrigueComment $comments
     * Les commentaires sur la fiche de l'intrigue
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\IntrigueComment", mappedBy="intrigue", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OrderBy({"created_at" = "DESC"})
     */
    private $comments;

    /**
     * Évènements de scénographie nécessaire à cette intrigue
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\ChronoBundle\Entity\Sceno", mappedBy="intrigue")
     */
    private $scenos;

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
     * Set writer
     *
     * @param Urbicande\UserBundle\Entity\User $writer
     * @return Intrigue
     */
    public function setWriter(\Urbicande\UserBundle\Entity\User $writer)
    {
        $this->writer = $writer;
    
        return $this;
    }

    /**
     * Get writer
     *
     * @return Urbicande\UserBundle\Entity\User
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Set synopsis
     *
     * @param Urbicande\IntrigueBundle\Entity\Synopsis $synopsis
     * @return Intrigue
     */
    public function setSynopsis(\Urbicande\IntrigueBundle\Entity\Synopsis $synopsis)
    {   
        $this->synopsis = $synopsis;
    
        return $this;
    }

    /**
     * Get synopsis
     *
     * @return Urbicande\IntrigueBundle\Entity\Synopsis
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set plot
     *
     * @param Urbicande\IntrigueBundle\Entity\Plot $plot
     * @return Intrigue
     */
    public function setPlot(\Urbicande\IntrigueBundle\Entity\Plot $plot)
    {
        $plot->setIntrigue($this);
        $this->plot = $plot;
    
        return $this;
    }

    /**
     * Get plot
     *
     * @return Urbicande\IntrigueBundle\Entity\Plot
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rules = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set type
     *
     * @param Urbicande\IntrigueBundle\Entity\IntrigueType $type
     * @return Intrigue
     */
    public function setType(\Urbicande\IntrigueBundle\Entity\IntrigueType $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return Urbicande\IntrigueBundle\Entity\IntrigueType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add objects
     *
     * @param Urbicande\IntrigueBundle\Entity\Object $objects
     * @return Intrigue
     */
    public function addObject(\Urbicande\IntrigueBundle\Entity\Object $objects)
    {
        $this->objects[] = $objects;
    
        return $this;
    }

    /**
     * Remove objects
     *
     * @param Urbicande\IntrigueBundle\Entity\Object $objects
     */
    public function removeObject(\Urbicande\IntrigueBundle\Entity\Object $objects)
    {
        $this->objects->removeElement($objects);
    }

    /**
     * Add rule
     *
     * @param Urbicande\IntrigueBundle\Entity\Rule $rule
     * @return Intrigue
     */
    public function addRule(\Urbicande\IntrigueBundle\Entity\Rule $rule)
    {
        $rule->setIntrigue($this);
        $this->rules[] = $rule;
    
        return $this;
    }

    /**
     * Remove rule
     *
     * @param Urbicande\IntrigueBundle\Entity\Rule $rule
     */
    public function removeRule(\Urbicande\IntrigueBundle\Entity\Rule $rule)
    {
        $this->rules->removeElement($rule);
    }

    /**
     * Get objects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Get rules
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Personnage
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
     * Set number
     *
     * @param integer $number
     * @return Intrigue
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Personnage
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
     * Get status in full word
     *
     * @return string 
     */
    public function getFullStatus()
    {
      switch ($this->status) {
        case 'C':
          return 'Créé';
          break;
        case 'S':
          return 'Pitché';
          break;
        case 'D':
          return 'Développé';
          break;
        case 'R':
          return 'Relu';
          break;
       } 
    }
    
    /**
     * Overrides default toString behaviour
     */
    public function __toString()
    {
        return $this->name.' ('.$this->type->getName().' '.$this->number.')';
    }

    /**
     * Add implication
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $implication
     * @return Intrigue
     */
    public function addImplication(\Urbicande\IntrigueBundle\Entity\Implication $implication)
    {
        $implication->setIntrigue($this);
        $this->implications[] = $implication;
    
        return $this;
    }

    /**
     * Remove implication
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $implication
     */
    public function removeImplication(\Urbicande\IntrigueBundle\Entity\Implication $implication)
    {
        $this->implications->removeElement($implication);
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

    /**
     * Add event
     *
     * @param \Urbicande\ChronoBundle\Entity\Event $event
     * @return Personnage
     */
    public function addEvent(\Urbicande\ChronoBundle\Entity\Event $event)
    {
        $this->events[] = $event;
    
        return $this;
    }

    /**
     * Remove event
     *
     * @param \Urbicande\ChronoBundle\Entity\Event $event
     */
    public function removeEvent(\Urbicande\ChronoBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Sets the events for this intrigue
     * @param ArrayCollection $events Liste des nouveaux évènements
     * @param boolean $create Si la fonction est utilisé à la création de l'entité
     */
    public function setEvents($events, $create = false)
    {
      if(!$create){
        foreach ($this->getEvents()->getSnapshot() as $key => $event) {
          if($event->getIntrigues()->contains($this)) {
              $event->getIntrigues()->removeElement($this);
          }
        }
      }   

      if($events) {
        foreach ($events as $key => $event) {
          if(!$event->getIntrigues()->contains($this)) {
              $event->addIntrigue($this);
          }
        }
      }
    }

    /**
     * Add comment
     *
     * @param Urbicande\IntrigueBundle\Entity\IntrigueComment $comment
     * @return Intrigue
     */
    public function addComment(\Urbicande\IntrigueBundle\Entity\IntrigueComment $comment)
    {
        $this->comments[] = $comment;
    
        return $this;
    }

    /**
     * Remove comment
     *
     * @param Urbicande\IntrigueBundle\Entity\IntrigueComment $comment
     */
    public function removeComment(\Urbicande\IntrigueBundle\Entity\IntrigueComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }


    /**
     * Add skills
     *
     * @param \Urbicande\PersoBundle\Entity\Skill $skills
     * @return Intrigue
     */
    public function addSkill(\Urbicande\PersoBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;
    
        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Urbicande\PersoBundle\Entity\Skill $skills
     */
    public function removeSkill(\Urbicande\PersoBundle\Entity\Skill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Add scenos
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $scenos
     * @return Intrigue
     */
    public function addSceno(\Urbicande\ChronoBundle\Entity\Sceno $scenos)
    {
        $this->scenos[] = $scenos;
    
        return $this;
    }

    /**
     * Remove scenos
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $scenos
     */
    public function removeSceno(\Urbicande\ChronoBundle\Entity\Sceno $scenos)
    {
        $this->scenos->removeElement($scenos);
    }

    /**
     * Get scenos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScenos()
    {
        return $this->scenos;
    }

    public function getClass()
    {
        return 'Urbicande\IntrigueBundle\Entity\Intrigue';
    }
}