<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RelationType
 *
 * @ORM\Table(name="cyber_RelationType")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\RelationTypeRepository")
 * @Gedmo\Loggable
 */
class RelationType
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
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var  ArrayCollection \Urbicande\PersoBundle\Entity\Relation $relations
     * Les Relations de ce type
     *
     * @ORM\OneToMany(targetEntity="\Urbicande\PersoBundle\Entity\Relation", mappedBy="type")
     **/
    private $relations;

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
     * @return RelationType
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
     * @return RelationType
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
     * Constructor
     */
    public function __construct()
    {
        $this->relations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add relations
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relations
     * @return RelationType
     */
    public function addRelation(\Urbicande\PersoBundle\Entity\Relation $relations)
    {
        $this->relations[] = $relations;
    
        return $this;
    }

    /**
     * Remove relations
     *
     * @param \Urbicande\PersoBundle\Entity\Relation $relations
     */
    public function removeRelation(\Urbicande\PersoBundle\Entity\Relation $relations)
    {
        $this->relations->removeElement($relations);
    }

    /**
     * Get relations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Return a readable name
     * @return string The name of the type
     */
    public function __toString() 
    {
        return $this->name;
    }
}