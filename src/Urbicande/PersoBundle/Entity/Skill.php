<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Skill
 * Compétence de personnage
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Skill")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\SkillRepository")
 */
class Skill
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
     * @var Urbicande\UserBundle\Entity\User $writer
     * Le scénariste référent
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var string
     * Le nom de la compétence
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * La description de la compétence
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     * Le coût en point de création de la compétence
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="creation_point", type="smallint")
     */
    private $creation_point;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Personnage $players
     * Les personnages ayant la compétence
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Personnage", mappedBy="skills", cascade={"persist"})
     */
    private $players;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Intrigue $intrigues
     * Les intrigues nécessitant la compétence
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="skills", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_intrigue_skill")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $intrigues;

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
     * @return Skill
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
     * @return Skill
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
     * Set creation_point
     *
     * @param integer $creationPoint
     * @return Skill
     */
    public function setCreationPoint($creationPoint)
    {
        $this->creation_point = $creationPoint;
    
        return $this;
    }

    /**
     * Get creation_point
     *
     * @return integer 
     */
    public function getCreationPoint()
    {
        return $this->creation_point;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intrigues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add player
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $player
     * @return Groupe
     */
    public function addPlayer(\Urbicande\PersoBundle\Entity\Personnage $player)
    {   
        if(!$player->getSkills()->contains($this)) $player->addSkill($this);
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
        if($player->getSkills()->contains($this)) $player->getSkills()->removeElement($this);
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

    /**
     * Sets the caracters possessing this skill
     * @param ArrayCollection $players Liste des nouveaux personnages
     * @param boolean $create Si la fonction est utilisé à la création de l'entité
     */
    public function setPlayers($players, $create = false)
    {
      if(!$create){
        foreach ($this->getPlayers()->getSnapshot() as $key => $player) {
          if($player->getSkills()->contains($this)) {
              $player->getSkills()->removeElement($this);
          }
        }
      }   

      foreach ($players as $key => $player) {
          if(!$player->getSkills()->contains($this)) {
              $player->addSkill($this);
          }
      }
    }

    /**
     * Add intrigues
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigues
     * @return Skill
     */
    public function addIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigues)
    {
        $this->intrigues[] = $intrigues;
    
        return $this;
    }

    /**
     * Remove intrigues
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigues
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigues)
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
     * @return Skill
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
     * Overrides default toString behaviour
     */
    public function __toString()
    {
        return $this->name;
    }
}