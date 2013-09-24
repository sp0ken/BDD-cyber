<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\IntrigueBundle\Entity\Synopsis
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Synopsis")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\SynopsisRepository")
 */
class Synopsis
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
     * @var string $context
     * Le contexte historique ayant mené à une intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="context", type="text", nullable=true)
     */
    private $context;

    /**
     * @var string $ingame
     * Les développement en jeu attendu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="ingame", type="text", nullable=true)
     */
    private $ingame;


    /**
     * @var Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     *
     * @ORM\OneToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", mappedBy="synopsis", cascade={"remove", "persist"})
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
     * Set context
     *
     * @param string $context
     * @return Synopsis
     */
    public function setContext($context)
    {
        $this->context = $context;
    
        return $this;
    }

    /**
     * Get context
     *
     * @return string 
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set ingame
     *
     * @param string $ingame
     * @return Synopsis
     */
    public function setIngame($ingame)
    {
        $this->ingame = $ingame;
    
        return $this;
    }

    /**
     * Get ingame
     *
     * @return string 
     */
    public function getIngame()
    {
        return $this->ingame;
    }

    public function getParent()
    {
        return $this->intrigue;
    }
}