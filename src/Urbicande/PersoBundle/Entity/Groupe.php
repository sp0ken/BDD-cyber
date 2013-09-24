<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\PersoBundle\Entity\Groupe
 * Groupe de personnage
 * 
 * @ORM\Table(name="cyber_Groupe")
 * @Gedmo\Loggable
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\GroupeRepository")
 */
class Groupe
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
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="groupes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var string $name
     * Le nom du groupe
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La, courte, description du groupe
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $particularity
     * Les particularités (signe de reconnaissance) du groupe
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="particularity", type="text", nullable=true)
     */
    private $particularity;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Personnage $members
     * Les personnages liés au groupe
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Personnage", mappedBy="groupes", cascade={"persist"})
     */
    private $members;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Implication $intrigues
     * Les intrigues liées à ce groupe
     *
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Implication", mappedBy="groupe", cascade={"persist", "remove"})
     */
    private $intrigues;
    
    /**
     * @var ArrayCollection Urbicande\ChronoBundle\Entity\Event $events
     * Les évènements auxquels à participer le groupe
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\ChronoBundle\Entity\Event", mappedBy="groupes", cascade={"persist"})
     */
    private $events;

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
     * @return Groupe
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
     * @return Groupe
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
     * Set particularity
     *
     * @param string $particularity
     * @return Groupe
     */
    public function setParticularity($particularity)
    {
        $this->particularity = $particularity;
    
        return $this;
    }

    /**
     * Get particularity
     *
     * @return string 
     */
    public function getParticularity()
    {
        return $this->particularity;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add member
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $member
     * @return Groupe
     */
    public function addMember(\Urbicande\PersoBundle\Entity\Personnage $member)
    {   
        if(!$member->getGroupes()->contains($this)) $member->addGroupe($this);
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $member
     */
    public function removeMember(\Urbicande\PersoBundle\Entity\Personnage $member)
    {   
        if($member->getGroupes()->contains($this)) $member->getGroupes()->removeElement($this);
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Sets the members of this groupe (used to make many to many works)
     * @param ArrayCollection $members
     */
    public function setMembers($members, $create = false)
    {
      if(!$create) {
        foreach ($this->getMembers()->getSnapshot() as $key => $member) {
          if($member->getGroupes()->contains($this)) {
            $member->getGroupes()->removeElement($this);
          }
        }
      }
      

      foreach ($members as $key => $member) {
        if(!$member->getGroupes()->contains($this)) {
          $member->addGroupe($this);
        }
      }
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add intrigues
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $intrigues
     * @return Groupe
     */
    public function addIntrigue(\Urbicande\IntrigueBundle\Entity\Implication $intrigues)
    {
        $this->intrigues[] = $intrigues;
    
        return $this;
    }

    /**
     * Remove intrigues
     *
     * @param \Urbicande\IntrigueBundle\Entity\Implication $intrigues
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Implication $intrigues)
    {
        $this->intrigues->removeElement($intrigues);
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

    /**
     * Set writer
     *
     * @param \Urbicande\UserBundle\Entity\User $writer
     * @return Groupe
     */
    public function setWriter(\Urbicande\UserBundle\Entity\User $writer)
    {
        $this->writer = $writer;
    
        return $this;
    }

    /**
     * Get writer
     *
     * @return \Urbicande\UserBundle\Entity\User 
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Add event
     *
     * @param \Urbicande\ChronoBundle\Entity\Event $event
     * @return Groupe
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
}