<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Objet de jeu
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Object")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\ObjectRepository")
 */
class Object
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
     * @var string $creator
     * La personne s'occupant de la création de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="creator", type="string", length=255)
     */
    private $creator;

    /**
     * @var string $name
     * Le nom de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La description de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var Urbicande\IntrigueBundle\Entity\ObjectType $type
     * Le type de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\ObjectType", inversedBy="objects", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var Urbicande\PersoBundle\Entity\Personnage $owner
     * Le possesseur de l'objet en début de jeu
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\PersoBundle\Entity\Personnage", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $owner;

    /**
     * @var boolean $is_owned
     * Si l'objet est possédé en début de jeu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="is_owned", type="boolean")
     */
    private $is_owned;

    /**
     * @var string $place
     * Le lieu où est l'objet en début de jeu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="place", type="text", nullable=true)
     */
    private $place;

    /**
     * @var boolean $is_placed
     * Si l'objet est placé en début de jeu
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="is_placed", type="boolean")
     */
    private $is_placed;

     /**
     * @var string $appearance
     * Condition d'apparition de l'objet
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="appearance", type="text", nullable=true)
     */
    private $appearance;

    /**
     * @var boolean $is_appear
     * Si l'objet à des conditions d'apparition
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="is_appear", type="boolean")
     */
    private $is_appear;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Data $datas
     * Les données contenues par l'objet
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Data", inversedBy="documents", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cyber_data_object")
     */
    private $datas;

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
     * Constructor
     */
    public function __construct()
    {
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Object
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
     * @return Object
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
     * Set is_owned
     *
     * @param boolean $isOwned
     * @return Object
     */
    public function setIsOwned($isOwned)
    {
        $this->is_owned = $isOwned;
    
        return $this;
    }

    /**
     * Get is_owned
     *
     * @return boolean 
     */
    public function getIsOwned()
    {
        return $this->is_owned;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Object
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set is_placed
     *
     * @param boolean $isPlaced
     * @return Object
     */
    public function setIsPlaced($isPlaced)
    {
        $this->is_placed = $isPlaced;
    
        return $this;
    }

    /**
     * Get is_placed
     *
     * @return boolean 
     */
    public function getIsPlaced()
    {
        return $this->is_placed;
    }

    /**
     * Set appearance
     *
     * @param string $appearance
     * @return Object
     */
    public function setAppearance($appearance)
    {
        $this->appearance = $appearance;
    
        return $this;
    }

    /**
     * Get appearance
     *
     * @return string 
     */
    public function getAppearance()
    {
        return $this->appearance;
    }

    /**
     * Set is_appear
     *
     * @param boolean $isAppear
     * @return Object
     */
    public function setIsAppear($isAppear)
    {
        $this->is_appear = $isAppear;
    
        return $this;
    }

    /**
     * Get is_appear
     *
     * @return boolean 
     */
    public function getIsAppear()
    {
        return $this->is_appear;
    }

    /**
     * Set category
     *
     * @param \Urbicande\IntrigueBundle\Entity\ObjectType $category
     * @return Object
     */
    public function setType(\Urbicande\IntrigueBundle\Entity\ObjectType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Urbicande\IntrigueBundle\Entity\ObjectType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set owner
     *
     * @param \Urbicande\PersoBundle\Entity\Personnage $owner
     * @return Object
     */
    public function setOwner(\Urbicande\PersoBundle\Entity\Personnage $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Urbicande\PersoBundle\Entity\Personnage 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add datas
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $datas
     * @return Object
     */
    public function addData(\Urbicande\IntrigueBundle\Entity\Data $datas)
    {
        $this->datas[] = $datas;
    
        return $this;
    }

    /**
     * Remove datas
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $datas
     */
    public function removeData(\Urbicande\IntrigueBundle\Entity\Data $datas)
    {
        $this->datas->removeElement($datas);
    }

    /**
     * Get datas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Object
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
     * Sets where the object is at the beginning of a game
     * Player/place/condition of appearance
     */
    public function setOrigin()
    {
        $owner = $this->getOwner();
        $place = $this->getPlace();
        $appearance = $this->getAppearance();
        if(!empty($owner)) {
            $this->setIsOwned(true);
            $this->setIsPlaced(false);
            $this->setIsAppear(false);
        } elseif(!empty($place)) {
            $this->setIsOwned(false);
            $this->setIsPlaced(true);
            $this->setIsAppear(false);
        } elseif(!empty($appearance)) {
            $this->setIsOwned(false);
            $this->setIsPlaced(false);
            $this->setIsAppear(true);
        } else {
            $this->setIsOwned(false);
            $this->setIsPlaced(false);
            $this->setIsAppear(false);
        }
        return $this;
    }

    /**
     * Returns where the object is at the beginning of a game
     * Player/place/condition of appearance
     * @return Personnage|string
     */
    public function getOrigin()
    {
        if($this->is_owned) {
            return 'Possédé par '.$this->owner;
        } elseif ($this->is_placed) {
            return $this->place;
        } elseif ($this->is_appear) {
            return 'Apparait avec la condition suivante: '.$this->appearance;
        } else {
            return 'Cet objet n‘a pas de position en début de jeu';
        }
    }

    /**
     * Overrides default toString behaviour
     */
    public function __toString()
    {
        return $this->name.' ('.$this->type.')';
    }
}