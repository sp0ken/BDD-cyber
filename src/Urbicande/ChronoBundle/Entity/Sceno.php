<?php

namespace Urbicande\ChronoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sceno
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Sceno")
 * @ORM\Entity(repositoryClass="Urbicande\ChronoBundle\Entity\ScenoRepository")
 */
class Sceno
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
     * @var string $creator
     * La personne s'occupant de la création de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="creator", type="string", length=255)
     */
    private $creator;

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
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Object", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_sceno_object")
     */
    private $objects;

    /**
     *
     * @ORM\OneToMany(targetEntity="Urbicande\ChronoBundle\Entity\Timing", mappedBy="sceno", cascade={"persist", "remove"})
     */
    private $timings;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\ChronoBundle\Entity\Sceno", inversedBy="children", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_sceno_parent",
     *      joinColumns={@ORM\JoinColumn(name="sceno_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sceno_parent_id", referencedColumnName="id")}
     *      )
     */
    private $parents;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Urbicande\ChronoBundle\Entity\Sceno", mappedBy="parents", cascade={"persist", "remove"})
     */
    private $children;

    /**
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="scenos")
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
     * Set description
     *
     * @param string $description
     * @return Sceno
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
        $this->timings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add objects
     *
     * @param \Urbicande\IntrigueBundle\Entity\Object $objects
     * @return Sceno
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
     * Add timing
     *
     * @param \Urbicande\ChronoBundle\Entity\Timing $timing
     * @return Sceno
     */
    public function addTiming(\Urbicande\ChronoBundle\Entity\Timing $timing)
    {
        $timing->setSceno($this);
        $this->timings[] = $timing;
    
        return $this;
    }

    /**
     * Remove timing
     *
     * @param \Urbicande\ChronoBundle\Entity\Timing $timing
     */
    public function removeTiming(\Urbicande\ChronoBundle\Entity\Timing $timing)
    {
        $this->timings->removeElement($timing);
    }

    /**
     * Get timings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimings()
    {
        return $this->timings;
    }

    /**
     * Add children
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $children
     * @return Sceno
     */
    public function addChildren(\Urbicande\ChronoBundle\Entity\Sceno $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $children
     */
    public function removeChildren(\Urbicande\ChronoBundle\Entity\Sceno $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Sceno
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return string 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add parents
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $parents
     * @return Sceno
     */
    public function addParent(\Urbicande\ChronoBundle\Entity\Sceno $parents)
    {
        $this->parents[] = $parents;
    
        return $this;
    }

    /**
     * Remove parents
     *
     * @param \Urbicande\ChronoBundle\Entity\Sceno $parents
     */
    public function removeParent(\Urbicande\ChronoBundle\Entity\Sceno $parents)
    {
        $this->parents->removeElement($parents);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParents()
    {
        return $this->parents;
    }

    public function getFullTiming()
    {
      if($this->timings->count() == 1){
          return $this->timings->first();
      } else {
        return $this->timings->count().' occurences. Première : '.$this->timings->first();
      }
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Sceno
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set intrigue
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Sceno
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

    public function getClass()
    {
        return 'Urbicande\ChronoBundle\Entity\Sceno';
    }
}