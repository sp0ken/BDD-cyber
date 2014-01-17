<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Type d'objet
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_ObjectType")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\ObjectTypeRepository")
 */
class ObjectType
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
     * @var string $name
     * Le nom du type d'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La description du type
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var  ArrayCollection \Urbicande\IntrigueBundle\Entity\Object $objects
     * Les objets de ce type
     * 
     * @ORM\OneToMany(targetEntity="\Urbicande\IntrigueBundle\Entity\Object", mappedBy="type")
     **/
    private $objects;

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
     * @return ObjectType
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
     * @return ObjectType
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
        $this->objects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add objects
     *
     * @param \Urbicande\IntrigueBundle\Entity\Object $objects
     * @return ObjectType
     */
    public function addObject(\Urbicande\IntrigueBundle\Entity\Object $objects)
    {
        $this->objects[] = $objects;
    
        return $this;
    }

    /**
     * Remove objects
     *
     * @param \Urbicande\IntrigueBundle\Entity\Object $objects
     */
    public function removeObject(\Urbicande\IntrigueBundle\Entity\Object $objects)
    {
        $this->objects->removeElement($objects);
    }

    /**
     * Get objects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Overrides default toString behaviour
     */
    public function __toString()
    {
        return $this->name;
    }
}