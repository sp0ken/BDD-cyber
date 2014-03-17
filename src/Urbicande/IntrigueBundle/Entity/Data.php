<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Pièce d'information
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_Data")
 * @ORM\Entity
 */
class Data
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
     * @var Urbicande\IntrigueBundle\Entity\Plot $plot
     * Intrigue dans laquelle apparait la donnée 
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Plot", inversedBy="datas", cascade={"persist"})
     */
    private $plot;

    /**
     * @var integer $number
     * Le numéro de la donnée (utilisé pour le classement)
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="number", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $number;

    /**
     * @var string $information
     * La donnée en elle-même
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="information", type="text")
     */
    private $information;

    /**
     * @var ArrayCollection Urbicande\PersoBundle\Entity\Personnage $knowers
     * Qui connait l'information
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\PersoBundle\Entity\Personnage", inversedBy="datas", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_data_personnage")
     */
    private $knowers;

    /**
     * @var ArrayCollection Urbicande\IntrigueBundle\Entity\Object $documents
     * Les objets contenant l'information
     * 
     * @ORM\ManyToMany(targetEntity="Urbicande\IntrigueBundle\Entity\Object", mappedBy="datas", cascade={"persist"})
     * @ORM\JoinTable(name="cyber_data_object")
     */
    private $documents;


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
     * Set information
     *
     * @param string $information
     * @return Data
     */
    public function setInformation($information)
    {
        $this->information = $information;
    
        return $this;
    }

    /**
     * Get information
     *
     * @return string 
     */
    public function getInformation()
    {
        return $this->information;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->knowers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add knowers
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $knowers
     * @return Data
     */
    public function addKnower(\Urbicande\PersoBundle\Entity\Personnage $knowers)
    {
        $this->knowers[] = $knowers;
    
        return $this;
    }

    /**
     * Remove knowers
     *
     * @param Urbicande\PersoBundle\Entity\Personnage $knowers
     */
    public function removeKnower(\Urbicande\PersoBundle\Entity\Personnage $knowers)
    {
        $this->knowers->removeElement($knowers);
    }

    /**
     * Get knowers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getKnowers()
    {
        return $this->knowers;
    }

    /**
     * Sets the knowers of this groupe (used to make many to many works)
     * @param ArrayCollection $knowers
     */
    public function setKnowers($knowers, $create = false)
    {
      if(!$create) {
        foreach ($this->getKnowers()->getSnapshot() as $key => $knower) {
          if($knower->getDatas()->contains($this)) {
            $knower->getDatas()->removeElement($this);
          }
        }
      }

      foreach ($knowers as $key => $knower) {
        if(!$knower->getDatas()->contains($this)) {
          $knower->addData($this);
        }
      }
    }

    /**
     * Set documents
     *
     * @param ArrayCollection $documents
     */
    public function setDocuments($documents, $create = false)
    {
      if(!$create) {
        foreach ($this->getDocuments()->getSnapshot() as $key => $document) {
          if($document->getDatas()->contains($this)) {
            $document->getDatas()->removeElement($this);
          }
        }
      }

      foreach ($documents as $key => $document) {
        if(!$document->getDatas()->contains($this)) {
          $document->addData($this);
        }
      }
    }

    /**
     * Add documents
     *
     * @param Urbicande\IntrigueBundle\Entity\Object $documents
     * @return Data
     */
    public function addDocument(\Urbicande\IntrigueBundle\Entity\Object $documents)
    {
        $this->documents[] = $documents;
    
        return $this;
    }

    /**
     * Remove documents
     *
     * @param Urbicande\IntrigueBundle\Entity\Object $documents
     */
    public function removeDocument(\Urbicande\IntrigueBundle\Entity\Object $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Data
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
     * Set plot
     *
     * @param \Urbicande\IntrigueBundle\Entity\Plot $plot
     * @return Data
     */
    public function setPlot(\Urbicande\IntrigueBundle\Entity\Plot $plot = null)
    {
        error_log('setPlot');
        $this->plot = $plot;
    
        return $this;
    }

    /**
     * Get plot
     *
     * @return \Urbicande\IntrigueBundle\Entity\Plot 
     */
    public function getPlot()
    {
        error_log('getPlot');
        return $this->plot;
    }
}