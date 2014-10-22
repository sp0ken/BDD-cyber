<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Relation
 *
 * @ORM\Table(name="cyber_Relation")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\RelationRepository")
 * @Gedmo\Loggable
 */
class Relation
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
     * @var Urbicande\PersoBundle\Entity\RelationType $type
     * Le type de relation entre personnages (parent, ennemi, etc.)
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\RelationType", inversedBy="relations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

     /**
     * @var  ArrayCollection \Urbicande\PersoBundle\Entity\Personnage $knower
     * Le personnage qui connait
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="\Urbicande\PersoBundle\Entity\Personnage", inversedBy="relationsTo")
     **/
    private $knower;

     /**
     * @var  ArrayCollection \Urbicande\PersoBundle\Entity\Personnage $knowee
     * Le personnage qui est connu
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="\Urbicande\PersoBundle\Entity\Personnage", inversedBy="relationsFrom")
     **/
    private $knowee;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="detail", type="text")
     */
    private $detail;

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
     * Set detail
     *
     * @param string $detail
     * @return Relation
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    
        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set type
     *
     * @param \Urbicande\PersoBundle\Entity\RelationType $type
     * @return Relation
     */
    public function setType(\Urbicande\PersoBundle\Entity\RelationType $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Urbicande\PersoBundle\Entity\RelationType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set knower
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $knower
     * @return Relation
     */
    public function setKnower(\Urbicande\PersoBundle\Entity\Personnage $knower = null)
    {
        $this->knower = $knower;
    
        return $this;
    }

    /**
     * Get knower
     *
     * @return \Urbicande\PersoBundle\Entity\Personnage 
     */
    public function getKnower()
    {
        return $this->knower;
    }

    /**
     * Set knowee
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $knowee
     * @return Relation
     */
    public function setKnowee(\Urbicande\PersoBundle\Entity\Personnage $knowee = null)
    {
        $this->knowee = $knowee;
    
        return $this;
    }

    /**
     * Get knowee
     *
     * @return \Urbicande\PersoBundle\Entity\Personnage 
     */
    public function getKnowee()
    {
        return $this->knowee;
    }
}