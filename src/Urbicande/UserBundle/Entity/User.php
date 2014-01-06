<?php

namespace Urbicande\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Urbicande\RpgBundle\Entity\Stat as Stat;

/**
 * Urbicande\UserBundle\Entity\User
 *
 * @ORM\Table(name="cyber_User")
 * @ORM\Entity(repositoryClass="Urbicande\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Urbicande\UserBundle\Entity\Setting $setting
     *
     * @ORM\OneToOne(targetEntity="Urbicande\UserBundle\Entity\Setting", inversedBy="user", cascade={"persist", "remove"})
     */
    private $setting;

    /**
     * @var \Urbicande\RpgBundle\Entity\Stat $stat
     *
     * @ORM\OneToOne(targetEntity="\Urbicande\RpgBundle\Entity\Stat", inversedBy="user", cascade={"persist", "remove"})
     */
    private $stat;

    /**
     * @var \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     *
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", mappedBy="writer")
     */
    private $intrigues;

    /**
     * @var \Urbicande\PersoBundle\Entity\Personnage $persos
     *
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\Personnage", mappedBy="writer")
     */
    private $persos;

    /**
     * @var \Urbicande\IntrigueBundle\Entity\Rule $rules
     *
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Rule", mappedBy="writer")
     */
    private $rules;

    /**
     * @var \Urbicande\PersoBundle\Entity\Groupe $groupes
     *
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\Groupe", mappedBy="writer")
     */
    private $groupes;

    /**
     * @var \Urbicande\PersoBundle\Entity\Skill $skills
     *
     * @ORM\OneToMany(targetEntity="Urbicande\PersoBundle\Entity\Skill", mappedBy="writer")
     */
    private $skills;

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
     * Set isConfirmed
     *
     * @param boolean $isConfirmed
     * @return User
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
    
        return $this;
    }

    /**
     * Get isConfirmed
     *
     * @return boolean 
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setting = new Setting();
        $this->stat = new Stat();
        $this->stat->setUser($this);
        $this->intrigues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add intrigues
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigues
     * @return User
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
     * Add persos
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $persos
     * @return User
     */
    public function addPerso(\Urbicande\PersoBundle\Entity\Personnage $persos)
    {
        $this->persos[] = $persos;
    
        return $this;
    }

    /**
     * Remove persos
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $persos
     */
    public function removePerso(\Urbicande\PersoBundle\Entity\Personnage $persos)
    {
        $this->persos->removeElement($persos);
    }

    /**
     * Get persos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersos()
    {
        return $this->persos;
    }

    /**
     * Add rules
     *
     * @param \Urbicande\IntrigueBundle\Entity\Rule $rules
     * @return User
     */
    public function addRule(\Urbicande\IntrigueBundle\Entity\Rule $rules)
    {
        $this->rules[] = $rules;
    
        return $this;
    }

    /**
     * Remove rules
     *
     * @param \Urbicande\IntrigueBundle\Entity\Rule $rules
     */
    public function removeRule(\Urbicande\IntrigueBundle\Entity\Rule $rules)
    {
        $this->rules->removeElement($rules);
    }

    /**
     * Get rules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Add groupes
     *
     * @param \Urbicande\PersoBundle\Entity\Groupe $groupes
     * @return User
     */
    public function addGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupes)
    {
        $this->groupes[] = $groupes;
    
        return $this;
    }

    /**
     * Remove groupes
     *
     * @param \Urbicande\PersoBundle\Entity\Groupe $groupes
     */
    public function removeGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupes)
    {
        $this->groupes->removeElement($groupes);
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
     * Add skills
     *
     * @param \Urbicande\PersoBundle\Entity\Skill $skills
     * @return User
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

    public function __toString()
    {
        return ucfirst($this->getUsername());
    }

    /**
     * Set setting
     *
     * @param \Urbicande\UserBundle\Entity\Setting $setting
     * @return User
     */
    public function setSetting(\Urbicande\UserBundle\Entity\Setting $setting)
    {
        $this->setting = $setting;
    
        return $this;
    }

    /**
     * Get setting
     *
     * @return \Urbicande\UserBundle\Entity\Setting 
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * Set stat
     *
     * @param \Urbicande\RpgBundle\Entity\Stat $stat
     * @return User
     */
    public function setStat(\Urbicande\RpgBundle\Entity\Stat $stat)
    {
        $this->stat = $stat;
    
        return $this;
    }

    /**
     * Get stat
     *
     * @return \Urbicande\RpgBundle\Entity\Stat 
     */
    public function getStat()
    {
        return $this->stat;
    }
}