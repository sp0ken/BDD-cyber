<?php

namespace Urbicande\MiscBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Element musical
 * 
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Musique")
 * @ORM\Entity(repositoryClass="Urbicande\MiscBundle\Entity\MusiqueRepository")
 */
class Musique
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
     * Nom de la musique
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     * Numéro de la musique
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * @var string
     * Type de la musique
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="type", type="string", length=10)
     * @Assert\Choice(choices = {"Ambiance", "TDE"}, message = "Choisissez un type valide.")
     */
    private $type;


    /**
     * @var string
     * Description de la musique
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

     /**
     * @var string
     * @todo Qu'est-ce donc ?
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="tde", type="text", nullable=true)
     */
    private $tde;

     /**
     * @var string
     * Lien hypertext
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

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
     * @return Musique
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
     * Set number
     *
     * @param integer $number
     * @return Musique
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
     * Set type
     *
     * @param string $type
     * @return Musique
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Musique
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
     * Set tde
     *
     * @param string $tde
     * @return Musique
     */
    public function setTde($tde)
    {
        $this->tde = $tde;
    
        return $this;
    }

    /**
     * Get tde
     *
     * @return string 
     */
    public function getTde()
    {
        return $this->tde;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Musique
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    public function __toString()
    {
        return 'n°'.$this->number.' '.$this->name;
    }
}