<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\PersoBundle\Entity\Personnage
 * Personnage (PJ, PNJ, etc.)
 * 
 * @ORM\Table(name="cyber_Personnage")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\PersonnageRepository")
 * @UniqueEntity("number")
 * @Gedmo\Loggable
 */
class Personnage
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
     * Le scénariste référent
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="persos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var Urbicande\PersoBundle\Entity\PersonnageType $perso
     * Le type de personnage (PJ, PNJ, TEMP, etc.)
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\PersonnageType", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var Urbicande\PersoBundle\Entity\Level $level
     * Le niveau du personnage
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\Level", inversedBy="players")
     * @ORM\JoinColumn(nullable=true)
     */
    private $level;

    /**
     * @var integer $number
     * Le numéro, attribué par l'équipe, du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * @var string $status
     * Le statut de la fiche (créée, développée, relue)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string $name
     * Le nom du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string $sex
     * Le sexe du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="sex", type="string", length=2)
     * @Assert\Choice(choices = {"H", "F", "NA"}, message = "Choisissez un sexe valide.")
     */
    private $sex;

    /**
     * @var integer $age
     * L'age du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="age", type="smallint", nullable=true)
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "L'age ne peut être inférieur à 1"
     * )
     */
    private $age;

    /**
     * @var string $job
     * La profession du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="job", type="string", length=255,  nullable=true)
     */
    private $job;

    /**
     * @var integer $income
     * Le salaire du personnage par an
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="income", type="integer", nullable=true)
     */
    private $income;

    /**
     * @var string $concept
     * La courte présentation du concept personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="concept", type="text")
     */
    private $concept;

    /**
     * @var string $description
     * L'histoire du personnage
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $costume
     * Indications de costume
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="costume", type="text",  nullable=true)
     */
    private $costume;

    /**
     * @var ArrayCollection Urbicande\ChronoBundle\Entity\Event $events
     * Les évènements auxquels à participer le personnage
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\ChronoBundle\Entity\Event", mappedBy="players", cascade={"persist"})
     */
    private $events;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Groupe $groupes
     * Les groupes du personnage
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Groupe", inversedBy="members", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_personnage_groupe")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $groupes;

    /**
     * @var Urbicande\PersoBundle\Entity\Relation $relationsTo
     * Les relations de ce personnage avec d'autres
     *
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\Relation", mappedBy="knower", cascade={"persist", "remove"})
     */
    private $relationsTo;

    /**
     * @var Urbicande\PersoBundle\Entity\Relation $relationsFrom
     * Les relations de ce personnage par d'autres
     *
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\Relation", mappedBy="knowee", cascade={"persist", "remove"})
     */
    private $relationsFrom;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Skill $skills
     * Les compétence du personnage
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Skill", inversedBy="players", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_personnage_skill")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $skills;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Data $datas
     * Les informations connues du personnage
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Data", mappedBy="knowers", cascade={"persist"})
     */
    private $datas;

    /**
     * @var Urbicande\IntrigueBundle\Entity\Implication $intrigues
     * Les implications dans des intrigues du personnage
     *
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Implication", mappedBy="player", cascade={"persist", "remove"})
     */
    private $intrigues;

    /**
     * @var  ArrayCollection Urbicande\PersoBundle\Entity\PersonnageComment $comments
     * Les commentaires sur la fiche du personnage
     * 
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\PersonnageComment", mappedBy="perso", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @ORM\orderBy({"created_at" = "DESC"})
     */
    private $comments;

    /**
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
 
   /**
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;
    
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
     * Set type
     *
     * @param Urbicande\PersoBundle\Entity\PersonnageType $type
     * @return Personnage
     */
    public function setType(\Urbicande\PersoBundle\Entity\PersonnageType $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return Urbicande\PersoBundle\Entity\PersonnageType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Personnage
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
     * Set age
     *
     * @param integer $age
     * @return Personnage
     */
    public function setAge($age)
    {
        $this->age = $age;
    
        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set job
     *
     * @param string $job
     * @return Personnage
     */
    public function setJob($job)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set income
     *
     * @param integer $income
     * @return Personnage
     */
    public function setIncome($income)
    {
        $this->income = $income;
    
        return $this;
    }

    /**
     * Get income
     *
     * @return integer 
     */
    public function getIncome()
    {
        if(!$this->income) return 0;
        return $this->income;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Personnage
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
     * Set concept
     *
     * @param string $concept
     * @return Personnage
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;
    
        return $this;
    }

    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
    }

    /**
     * Set costume
     *
     * @param string $costume
     * @return Personnage
     */
    public function setCostume($costume)
    {
        $this->costume = $costume;
    
        return $this;
    }

    /**
     * Get costume
     *
     * @return string 
     */
    public function getCostume()
    {
        return $this->costume;
    }


    public function __toString()
    {
        return $this->type.' '.$this->number.' '.$this->name;
    }

    /**
     * Set intrigues
     *
     * @param Urbicande\IntrigueBundle\Entity\Implication $intrigues
     * @return Personnage
     */
    public function setIntrigues(\Urbicande\IntrigueBundle\Entity\Implication $intrigues = null)
    {
        $this->intrigues = $intrigues;
    
        return $this;
    }

    /**
     * Get intrigues
     *
     * @return Urbicande\IntrigueBundle\Entity\Implication 
     */
    public function getIntrigues()
    {
        return $this->intrigues;
    }

    /**
     * Add intrigues
     *
     * @param Urbicande\IntrigueBundle\Entity\Implication $intrigues
     * @return Personnage
     */
    public function addIntrigue(\Urbicande\IntrigueBundle\Entity\Implication $intrigue)
    {   
        $intrigue->setPlayer($this);
        $this->intrigues[] = $intrigue;
    
        return $this;
    }

    /**
     * Remove intrigues
     *
     * @param Urbicande\IntrigueBundle\Entity\Implication $intrigues
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Implication $intrigues)
    {
        $this->intrigues->removeElement($intrigues);
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intrigues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationsTo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationsFrom = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add groupe
     *
     * @param Urbicande\PersoBundle\Entity\Groupe $groupe
     * @return Personnage
     */
    public function addGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;
    
        return $this;
    }

    /**
     * Remove groupe
     *
     * @param Urbicande\PersoBundle\Entity\Groupe $groupe
     */
    public function removeGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        if($groupe->getMembers()->contains($this)) $groupe->getMembers()->removeElement($this);
        $this->groupes->removeElement($groupe);
    }

    /**
     * Get groupes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Add comment
     *
     * @param Urbicande\PersoBundle\Entity\PersonnageComment $comment
     * @return Personnage
     */
    public function addComment(\Urbicande\PersoBundle\Entity\PersonnageComment $comment)
    {
        $this->comments[] = $comment;
    
        return $this;
    }

    /**
     * Remove comment
     *
     * @param Urbicande\PersoBundle\Entity\PersonnageComment $comment
     */
    public function removeComment(\Urbicande\PersoBundle\Entity\PersonnageComment $comment)
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Personnage
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Personnage
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add skill
     *
     * @param \Urbicande\PersoBundle\Entity\Skill $skill
     * @return Personnage
     */
    public function addSkill(\Urbicande\PersoBundle\Entity\Skill $skill)
    {           
        if(!$skill->getPlayers()->contains($this)) $skill->addPlayer($this);
        $this->skills[] = $skill;
    
        return $this;
    }

    /**
     * Remove skill
     *
     * @param \Urbicande\PersoBundle\Entity\Skill $skill
     */
    public function removeSkill(\Urbicande\PersoBundle\Entity\Skill $skill)
    {
        if($skill->getPlayers()->contains($this)) $skill->getPlayers()->removeElement($this);
        $this->skills->removeElement($skill);
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

    public function countCreationPoint()
    {   $count = 0;

        foreach ($this->skills as $key => $skill) {
           $count += $skill->getCreationPoint();
        }
        return $count;
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
     * Sets the events for this personnage
     * @param ArrayCollection $events Liste des nouveaux évènements
     * @param boolean $create Si la fonction est utilisé à la création de l'entité
     */
    public function setEvents($events, $create = false)
    {
      if(!$create){
        foreach ($this->getEvents()->getSnapshot() as $key => $event) {
          if($event->getPlayers()->contains($this)) {
              $event->getPlayers()->removeElement($this);
          }
        }
      }   

      if($events){
        foreach ($events as $key => $event) {
          if(!$event->getPlayers()->contains($this)) {
              $event->addPlayer($this);
          }
        }
      }
    }

    /**
     * Add data
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $data
     * @return Personnage
     */
    public function addData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $this->datas[] = $data;
    
        return $this;
    }

    /**
     * Remove data
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $data
     */
    public function removeData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $this->datas->removeElement($data);
    }

    /**
     * Get datas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Count the number of plots of specified type
     * @param  String $type name of intrigue's type
     * @return int
     */
    public function countIntrigueByType($type)
    {
        $count = 0;
        foreach ($this->intrigues as $key => $intrigue) {
            if ($intrigue->getIntrigue()->getType() == $type) {
                $count++;
            }
        }
        foreach ($this->groupes as $key => $groupe) {
            foreach ($groupe->getIntrigues() as $key => $intrigue) {
                if ($intrigue->getIntrigue()->getType() == $type) {
                    $count++;
                }
            }
        }
        foreach ($this->events as $key => $event) {
            foreach ($event->getIntrigues() as $key => $intrigue) {
                if ($intrigue->getType() == $type) {
                    $count++;
                }
            }
        }
        return $count;
    }

     /**
     * Count the number of plots of specified degree
     * @param  String $name degree of intrigue's implication
     * @return int
     */
    public function countIntrigueByDegree($degree)
    {
        $count = 0;
        foreach ($this->intrigues as $key => $intrigue) {
            if ($intrigue->getDegree() == $degree) {
                $count++;
            }
        }
        foreach ($this->groupes as $key => $groupe) {
            foreach ($groupe->getIntrigues() as $key => $intrigue) {
                if ($intrigue->getDegree() == $degree) {
                    $count++;
                }
            }
        }
        foreach ($this->events as $key => $event) {
            foreach ($event->getIntrigues() as $key => $intrigue) {
                if ($intrigue->getDegree() == $degree) {
                    $count++;
                }
            }
        }
        return $count;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Personnage
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    
        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Get sex in full word
     *
     * @return string 
     */
    public function getFullSex()
    {
        switch ($this->sex) {
            case 'H':
                return 'Homme';
                break;
            case 'F':
                return 'Femme';
                break;
            case 'NA':
                return 'Indéterminé';
                break;
            default:
                return 'Indéterminé';
                break;
        }
    }
    
    /**
     * Get class
     * @return string
     */
    public function getClass()
    {
        return 'Urbicande\PersoBundle\Entity\Personnage';
    }

    /**
     * Set level
     *
     * @param \Urbicande\PersoBundle\Entity\Level $level
     * @return Personnage
     */
    public function setLevel(\Urbicande\PersoBundle\Entity\Level $level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return \Urbicande\PersoBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add relationsTo
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relationsTo
     * @return Personnage
     */
    public function addRelationsTo(\Urbicande\PersoBundle\Entity\Relation $relationsTo)
    {
        $this->relationsTo[] = $relationsTo;
    
        return $this;
    }

    /**
     * Remove relationsTo
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relationsTo
     */
    public function removeRelationsTo(\Urbicande\PersoBundle\Entity\Relation $relationsTo)
    {
        $this->relationsTo->removeElement($relationsTo);
    }

    /**
     * Get relationsTo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationsTo()
    {
        return $this->relationsTo;
    }

    /**
     * Add relationsFrom
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relationsFrom
     * @return Personnage
     */
    public function addRelationsFrom(\Urbicande\PersoBundle\Entity\Relation $relationsFrom)
    {
        $this->relationsFrom[] = $relationsFrom;
    
        return $this;
    }

    /**
     * Remove relationsFrom
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relationsFrom
     */
    public function removeRelationsFrom(\Urbicande\PersoBundle\Entity\Relation $relationsFrom)
    {
        $this->relationsFrom->removeElement($relationsFrom);
    }

    /**
     * Get relationsFrom
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationsFrom()
    {
        return $this->relationsFrom;
    }
}