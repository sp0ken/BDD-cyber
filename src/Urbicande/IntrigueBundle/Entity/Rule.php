<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\IntrigueBundle\Entity\Rule
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Rule")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\RuleRepository")
 */
class Rule
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
     * @var integer $number
     * Le numéro de la règle (utilisé pour le tri)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="number", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $number;

    /**
     * @var Urbicande\UserBundle\Entity\User $writer
     * Le scénariste référent
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @var string $name
     * Le nom de la règle
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La règle en question
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="rules")
     * @ORM\JoinColumn(nullable=true)
     */
    private $intrigue;

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
     * @return Rule
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
     * @return Rule
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
     * Set isGeneral
     *
     * @param boolean $isGeneral
     * @return Rule
     */
    public function setIsGeneral($isGeneral)
    {
        $this->isGeneral = $isGeneral;
    
        return $this;
    }

    /**
     * Get isGeneral
     *
     * @return boolean 
     */
    public function getIsGeneral()
    {
        return $this->isGeneral;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intrigues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set number
     *
     * @param integer $number
     * @return Rule
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
     * Set writer
     *
     * @param \Urbicande\UserBundle\Entity\User $writer
     * @return Rule
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
        return $this->name;
    }

    /**
     * Set intrigue
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Rule
     */
    public function setIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue = null)
    {
        $this->intrigue = $intrigue;
    
        return $this;
    }

    /**
     * Get intrigue
     *
     * @return \Urbicande\IntrigueBundle\Entity\Intrigue 
     */
    public function getIntrigue()
    {
        return $this->intrigue;
    }
}