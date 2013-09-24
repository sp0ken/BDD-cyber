<?php

namespace Urbicande\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
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
     *
     * @ORM\Column(name="hasNotification", type="boolean")
     */
    private $hasNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hasRpg", type="boolean")
     */
    private $hasRpg;

    /**
     * @var \Urbicande\UserBundle\Entity\User $user
     *
     * @ORM\OneToOne(targetEntity="Urbicande\UserBundle\Entity\User", mappedBy="setting")
     */
    private $user;

    public function __construct()
    {
        $this->hasNotification = true;
        $this->hasRpg = true;
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
}