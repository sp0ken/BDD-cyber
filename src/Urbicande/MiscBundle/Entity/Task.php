<?php

namespace Urbicande\MiscBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Task
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_task")
 * @ORM\Entity(repositoryClass="Urbicande\MiscBundle\Entity\TaskRepository")
 */
class Task
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
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var Urbicande\UserBundle\Entity\User $writer
     * Le scénariste référent
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_done", type="boolean")
     */
    private $isDone;

    public function __construct()
    {
        $this->is_done = false;
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
     * Set text
     *
     * @param string $text
     * @return Task
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Task
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     * @return Task
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    
        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Set writer
     *
     * @param \Urbicande\UserBundle\Entity\User $writer
     * @return Task
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

    public function __toString()
    {
        if ($this->endDate != null) {
            $text = 'Tache : '.$this->text.' pour le '.$this->endDate->format('d/m/Y');
        } else {
            $text = 'Tache : '.$this->text;
        }
        
        return $text;
    }
}