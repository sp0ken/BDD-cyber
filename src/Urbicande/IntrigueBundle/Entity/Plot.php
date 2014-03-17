<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Détails d'une intrigue
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Plot")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\PlotRepository")
 */
class Plot
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
     * @var string $ingame
     * Développement en jeu de l'intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="ingame", type="text", nullable=true)
     */
    private $ingame;

    /**
     * @var string $motive
     * Motivation pour cette intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="motive", type="text", nullable=true)
     */
    private $motive;

    /**
     * @var string $resolution
     * Résolutions possible de l'intrigue
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="resolution", type="text", nullable=true)
     */
    private $resolution;

    /**
     * @var string $description
     * Description détaillée
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Data $datas
     * Données nécessaire à l'intrigue
     *
     * @ORM\OneToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Data", mappedBy="plot", cascade={"persist", "remove"})
     */
    private $datas;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * Intrigue parente
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", mappedBy="plot", cascade={"persist", "remove"})
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
     * Set ingame
     *
     * @param string $ingame
     * @return Plot
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

    /**
     * Set motive
     *
     * @param string $motive
     * @return Plot
     */
    public function setMotive($motive)
    {
        $this->motive = $motive;
    
        return $this;
    }

    /**
     * Get motive
     *
     * @return string 
     */
    public function getMotive()
    {
        return $this->motive;
    }

    /**
     * Set resolution
     *
     * @param string $resolution
     * @return Plot
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    
        return $this;
    }

    /**
     * Get resolution
     *
     * @return string 
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Plot
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
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set intrigue
     *
     * @param \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Plot
     */
    public function setIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
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

    /**
     * Add data
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $data
     * @return Plot
     */
    public function addData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $data->setPlot($this);
        $this->datas[] = $data;
    
        return $this;
    }

    /**
     * Remove data
     *
     * @param \Urbicande\IntrigueBundle\Entity\Data $data
     */
    public function removeData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $this->datas->removeElement($data);
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
     * Get parent (alias for getIntrigue)
     * @return \Urbicande\IntrigueBundle\Entity\Intrigue 
     */
    public function getParent()
    {
        return $this->intrigue;
    }
}