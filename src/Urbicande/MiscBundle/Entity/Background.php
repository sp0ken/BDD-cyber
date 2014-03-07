<?php

namespace Urbicande\MiscBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Document de Background du jeu
 * 
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Background")
 * @ORM\Entity(repositoryClass="Urbicande\MiscBundle\Entity\BackgroundRepository")
 */
class Background
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
     * Titre du document de back
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * Le texte principal du document de back
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="body", type="text")
     */
    private $body;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Background
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Background
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set writer
     *
     * @param \Urbicande\UserBundle\Entity\User $writer
     * @return Background
     */
    public function setWriter($writer)
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
     * Overrides toString default behaviour
     */
    public function __toString()
    {
        return $this->title;
    }
}