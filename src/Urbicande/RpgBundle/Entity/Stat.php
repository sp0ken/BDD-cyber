<?php

namespace Urbicande\RpgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 *
 * @ORM\Table(name="cyber_Stat")
 * @ORM\Entity
 */
class Stat
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
     * @var integer
     *
     * @ORM\Column(name="xp", type="integer")
     */
    private $xp;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

     /**
     * @var integer
     *
     * @ORM\Column(name="caracPoint", type="integer")
     */
    private $caracPoint;

    /**
     * @var integer
     *
     * @ORM\Column(name="ufologie", type="integer")
     */
    private $ufologie;

    /**
     * @var integer
     *
     * @ORM\Column(name="relecture", type="integer")
     */
    private $relecture;

    /**
     * @var integer
     *
     * @ORM\Column(name="blague", type="integer")
     */
    private $blague;

    /**
     * @var integer
     *
     * @ORM\Column(name="imagination", type="integer")
     */
    private $imagination;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", nullable=true)
     */
    private $avatar;

     /**
     * @var \Urbicande\UserBundle\Entity\User $user
     *
     * @ORM\OneToOne(targetEntity="\Urbicande\UserBundle\Entity\User", mappedBy="stat")
     */
    private $user;

    private $titles = array('Squatter', 'Relecteur débutant', 'Relecteur de qualité supérieure', 'Maître Relecteur', 'Scénariste débutant', 'Maître du Sechs', 'Scénariste de qualité supérieure', 'Maître Scénariste', 
                                         'Scribe', 'Moine copiste', 'Gérard de Villier', 'Secrètaire d\'Urbicande', 'Trésorier d\'Urbicande', 'Vice-Président d\'Urbicande', 'Président d\'Urbicande',
                                        'Maître du monde débutant', 'Maître du monde de qualité supérieure', 'Majeur', 'Contributeur pour Wikipedia', 'Sage de l\'Académie Française');

    public function __construct($xp = 0, $caracPoint = 0)
    {
        $this->xp = $xp;
        $this->level = floor($xp/100)+1;
        $this->caracPoint = $caracPoint;
        $this->ufologie = 1;
        $this->relecture = 1;
        $this->blague = 1;
        $this->imagination = 1;
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
     * Set xp
     *
     * @param integer $xp
     * @return Stat
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    
        return $this;
    }

    /**
     * Get xp
     *
     * @return integer 
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Return the percentage of the current level compare to the next
     * @return int
     */
    public function getRelativeXp()
    {
        return ($this->xp*100)/(pow($this->level+1, 2)*100);
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Stat
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
     * Set ufologie
     *
     * @param integer $ufologie
     * @return Stat
     */
    public function setUfologie($ufologie)
    {
        $this->ufologie = $ufologie;
    
        return $this;
    }

    /**
     * Get ufologie
     *
     * @return integer 
     */
    public function getUfologie()
    {
        return $this->ufologie;
    }

    /**
     * Set relecture
     *
     * @param integer $relecture
     * @return Stat
     */
    public function setRelecture($relecture)
    {
        $this->relecture = $relecture;
    
        return $this;
    }

    /**
     * Get relecture
     *
     * @return integer 
     */
    public function getRelecture()
    {
        return $this->relecture;
    }

    /**
     * Set blague
     *
     * @param integer $blague
     * @return Stat
     */
    public function setBlague($blague)
    {
        $this->blague = $blague;
    
        return $this;
    }

    /**
     * Get blague
     *
     * @return integer 
     */
    public function getBlague()
    {
        return $this->blague;
    }

    /**
     * Set imagination
     *
     * @param integer $imagination
     * @return Stat
     */
    public function setImagination($imagination)
    {
        $this->imagination = $imagination;
    
        return $this;
    }

    /**
     * Get imagination
     *
     * @return integer 
     */
    public function getImagination()
    {
        return $this->imagination;
    }

    /**
     * Set user
     *
     * @param \Urbicande\UserBundle\Entity\User $user
     * @return Stat
     */
    public function setUser(\Urbicande\UserBundle\Entity\User $user)
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
     * Set caracPoint
     *
     * @param integer $caracPoint
     * @return Stat
     */
    public function setCaracPoint($caracPoint)
    {
        $this->caracPoint = $caracPoint;
    
        return $this;
    }

    /**
     * Get caracPoint
     *
     * @return integer 
     */
    public function getCaracPoint()
    {
        return $this->caracPoint;
    }

    /**
     * Reset statistics based on xp value
     * @param  int $xp xp value
     */
    public function resetStat($xp)
    {
        $this->xp = $xp;
        $this->level = floor(sqrt($xp/100));
        $this->caracPoint = $this->level-1;
        $this->ufologie = 1;
        $this->relecture = 1;
        $this->blague = 1;
        $this->imagination = 1;
    }

    /**
     * Return caracter title based on its level
     * @return string Title
     */
    public function getTitle()
    {
        if($this->level <= 20) {
            return $this->titles[$this->level-1];
        } else {
            return 'Exploiteur de bug';
        }
    }

    /**
     * Add the given value to the user xp
     * @param int $xp
     */
    public function addXp($xp)
    {
        $this->xp += $xp;
    }

    /**
     * Substract the given value to the user xp
     * @param  [type] $xp
     */
    public function removeXp($xp)
    {
        $this->getXp();
        $this->xp -= $xp;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Stat
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getFullAvatar()
    {
        return 'bundles/urbicanderpg/images/portraits/'.$this->avatar.'.jpg';
    }
}