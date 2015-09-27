<?php

namespace Urbicande\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paramètres d'un utilisateur
 *
 * @ORM\Table(name="cyber_Setting")
 * @ORM\Entity(repositoryClass="Urbicande\UserBundle\Entity\SettingRepository")
 */
class Setting
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
     * @var boolean
     * Si les notification par mail sont activées
     *
     * @ORM\Column(name="hasNotification", type="boolean")
     */
    private $hasNotification;

    /**
     * @var boolean
     * Si l'affichage du module RPG est activé
     *
     * @ORM\Column(name="hasRpg", type="boolean")
     */
    private $hasRpg;

    /**
     * @var \Urbicande\UserBundle\Entity\User $user
     * Utilisateur parent
     *
     * @ORM\OneToOne(targetEntity="Urbicande\UserBundle\Entity\User", mappedBy="setting")
     */
    private $user;

    /**
     * @var integer
     * Taille du bloc "rpg"
     *
     * @ORM\Column(name="rpgSize", type="integer")
     */
    private $rpgSize;

    /**
     * @var integer
     * Taille du bloc "log"
     *
     * @ORM\Column(name="logSize", type="integer")
     */
    private $logSize;

    /**
     * @var integer
     * Taille du bloc "plot"
     *
     * @ORM\Column(name="plotSize", type="integer")
     */
    private $plotSize;

    /**
     * @var integer
     * Taille du bloc "perso"
     *
     * @ORM\Column(name="persoSize", type="integer")
     */
    private $persoSize;

    /**
     * @var integer
     * Taille du bloc "groupe"
     *
     * @ORM\Column(name="groupeSize", type="integer")
     */
    private $groupeSize;

    /**
     * @var integer
     * Taille du bloc "rule"
     *
     * @ORM\Column(name="ruleSize", type="integer")
     */
    private $ruleSize;

    /**
     * @var integer
     * Taille du bloc "skill"
     *
     * @ORM\Column(name="skillSize", type="integer")
     */
    private $skillSize;

    /**
     * @var integer
     * Taille du bloc "task"
     *
     * @ORM\Column(name="taskSize", type="integer")
     */
    private $taskSize;

    /**
     * @var string
     * Ordre des blocs de la page d'accueil
     *
     * @ORM\Column(name="blockOrder", type="string")
     */
    private $blockOrder;

    public function __construct()
    {
        $this->hasNotification = true;
        $this->hasRpg = true;
        $this->rpgSize = 6;
        $this->logSize = 6;
        $this->plotSize = 6;
        $this->persoSize = 6;
        $this->groupeSize = 6;
        $this->ruleSize = 6;
        $this->skillSize = 6;
        $this->taskSize = 6;
        $this->blockOrder = '1|2|3|4|5|6|7|8';
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
     * Set hasNotification
     *
     * @param boolean $hasNotification
     * @return Setting
     */
    public function setHasNotification($hasNotification)
    {
        $this->hasNotification = $hasNotification;
    
        return $this;
    }

    /**
     * Get hasNotification
     *
     * @return boolean 
     */
    public function getHasNotification()
    {
        return $this->hasNotification;
    }

    /**
     * Set hasRpg
     *
     * @param boolean $hasRpg
     * @return Setting
     */
    public function setHasRpg($hasRpg)
    {
        $this->hasRpg = $hasRpg;
    
        return $this;
    }

    /**
     * Get hasRpg
     *
     * @return boolean 
     */
    public function getHasRpg()
    {
        return $this->hasRpg;
    }

    /**
     * Set user
     *
     * @param \Urbicande\UserBundle\Entity\User $user
     * @return Setting
     */
    public function setUser(\Urbicande\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Urbicande\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set rpgSize
     *
     * @param integer $rpgSize
     * @return Setting
     */
    public function setRpgSize($rpgSize)
    {
        $this->rpgSize = $rpgSize;
    
        return $this;
    }

    /**
     * Get rpgSize
     *
     * @return integer 
     */
    public function getRpgSize()
    {
        return $this->rpgSize;
    }

    /**
     * Set logSize
     *
     * @param integer $logSize
     * @return Setting
     */
    public function setLogSize($logSize)
    {
        $this->logSize = $logSize;
    
        return $this;
    }

    /**
     * Get logSize
     *
     * @return integer 
     */
    public function getLogSize()
    {
        return $this->logSize;
    }

    /**
     * Set plotSize
     *
     * @param integer $plotSize
     * @return Setting
     */
    public function setPlotSize($plotSize)
    {
        $this->plotSize = $plotSize;
    
        return $this;
    }

    /**
     * Get plotSize
     *
     * @return integer 
     */
    public function getPlotSize()
    {
        return $this->plotSize;
    }

    /**
     * Set persoSize
     *
     * @param integer $persoSize
     * @return Setting
     */
    public function setPersoSize($persoSize)
    {
        $this->persoSize = $persoSize;
    
        return $this;
    }

    /**
     * Get persoSize
     *
     * @return integer 
     */
    public function getPersoSize()
    {
        return $this->persoSize;
    }

    /**
     * Set groupeSize
     *
     * @param integer $groupeSize
     * @return Setting
     */
    public function setGroupeSize($groupeSize)
    {
        $this->groupeSize = $groupeSize;
    
        return $this;
    }

    /**
     * Get groupeSize
     *
     * @return integer 
     */
    public function getGroupeSize()
    {
        return $this->groupeSize;
    }

    /**
     * Set ruleSize
     *
     * @param integer $ruleSize
     * @return Setting
     */
    public function setRuleSize($ruleSize)
    {
        $this->ruleSize = $ruleSize;
    
        return $this;
    }

    /**
     * Get ruleSize
     *
     * @return integer 
     */
    public function getRuleSize()
    {
        return $this->ruleSize;
    }

    /**
     * Set skillSize
     *
     * @param integer $skillSize
     * @return Setting
     */
    public function setSkillSize($skillSize)
    {
        $this->skillSize = $skillSize;
    
        return $this;
    }

    /**
     * Get skillSize
     *
     * @return integer 
     */
    public function getSkillSize()
    {
        return $this->skillSize;
    }

    /**
     * Set taskSize
     *
     * @param integer $taskSize
     * @return Setting
     */
    public function setTaskSize($taskSize)
    {
        $this->taskSize = $taskSize;
    
        return $this;
    }

    /**
     * Get taskSize
     *
     * @return integer 
     */
    public function getTaskSize()
    {
        return $this->taskSize;
    }

    /**
     * Set blockOrder
     *
     * @param string $blockOrder
     * @return Setting
     */
    public function setBlockOrder($blockOrder)
    {
        $this->blockOrder = $blockOrder;
    
        return $this;
    }

    /**
     * Get blockOrder
     *
     * @return string 
     */
    public function getBlockOrder()
    {
        return $this->blockOrder;
    }
}