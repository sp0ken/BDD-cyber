<?php

namespace Urbicande\ChronoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Horaire d'un évènement de scénographie
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Timing")
 * @ORM\Entity(repositoryClass="Urbicande\ChronoBundle\Entity\TimingRepository")
 */
class Timing
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
     * Jour de départ
     * Nombre simple en comptant à partir du début du jeu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="start_day", type="smallint")
     */
    private $start_day;

    /**
     * @var integer
     * Jour de fin
     * Nombre simple en comptant à partir du début du jeu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="end_day", type="smallint", nullable=true)
     */
    private $end_day;

    /**
     * @var \DateTime
     * Heure de départ
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="start_hour", type="time")
     */
    private $start_hour;

    /**
     * @var \DateTime
     * Heure de fin
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="end_hour", type="time", nullable=true)
     */
    private $end_hour;

    /**
     * Évènements de scénographie à cette horaire
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\ChronoBundle\Entity\Sceno", inversedBy="timings")
     */
    private $sceno;

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
     * Set start_day
     *
     * @param integer $startDay
     * @return Timing
     */
    public function setStartDay($startDay)
    {
        $this->start_day = $startDay;
    
        return $this;
    }

    /**
     * Get start_day
     *
     * @return integer 
     */
    public function getStartDay()
    {
        return $this->start_day;
    }

    /**
     * Set end_day
     *
     * @param integer $endDay
     * @return Timing
     */
    public function setEndDay($endDay)
    {
        $this->end_day = $endDay;
    
        return $this;
    }

    /**
     * Get end_day
     *
     * @return integer 
     */
    public function getEndDay()
    {
        return $this->end_day;
    }

    /**
     * Set start_hour
     *
     * @param \DateTime $startHour
     * @return Timing
     */
    public function setStartHour($startHour)
    {
        $this->start_hour = $startHour;
    
        return $this;
    }

    /**
     * Get start_hour
     *
     * @return \DateTime 
     */
    public function getStartHour()
    {
        return $this->start_hour;
    }

    /**
     * Set end_hour
     *
     * @param \DateTime $endHour
     * @return Timing
     */
    public function setEndHour($endHour)
    {
        $this->end_hour = $endHour;
    
        return $this;
    }

    /**
     * Get end_hour
     *
     * @return \DateTime 
     */
    public function getEndHour()
    {
        return $this->end_hour;
    }

    /**
     * Set sceno
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $sceno
     * @return Timing
     */
    public function setSceno(\Urbicande\ChronoBundle\Entity\Sceno $sceno = null)
    {
        $this->sceno = $sceno;
    
        return $this;
    }

    /**
     * Get sceno
     *
     * @return \Urbicande\ChronoBundle\Entity\Sceno 
     */
    public function getSceno()
    {
        return $this->sceno;
    }

    /**
     * Overrides default toString behaviour
     * @return string
     */
    public function __toString()
    {
      if($this->end_hour){
        return 'De jour '.$this->start_day.' à '.$this->start_hour->format('H:i').' à jour '.$this->end_day.' à '.$this->end_hour->format('H:i');
      } else {
        return 'Jour '.$this->start_day.' à '.$this->start_hour->format('H:i');
      }
    }

    /**
     * Get parent (alias for getSceno())
     * @return \Urbicande\ChronoBundle\Entity\Sceno
     */
    public function getParent()
    {
        return $this->sceno;
    }
}