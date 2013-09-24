<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\IntrigueBundle\Entity\IntrigueType
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_IntrigueType")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\IntrigueTypeRepository")
 */
class IntrigueType
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
     * Le nom de ce type d'intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     * La description de ce type d'intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var  ArrayCollection \Urbicande\IntrigueBundle\Entity\Intrigue $players
     * Les intrigues de ce type
     * 
     * @ORM\OneToMany(targetEntity="\Urbicande\IntrigueBundle\Entity\Intrigue", mappedBy="type")
     **/
    private $intrigues;

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
     * @return Type
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
     * @return Type
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
     * Add intrigue
     *
     * @param Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return IntrigueType
     */
    public function addIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigues[] = $intrigue;
    
        return $this;
    }

    /**
     * Remove intrigue
     *
     * @param Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigues->removeElement($intrigue);
    }

    /**
     * Get intrigues
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIntrigues()
    {
        return $this->intrigues;
    }

    public function __toString()
    {
        return $this->name;
    }
}