<?php

namespace Urbicande\PersoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Urbicande\PersoBundle\Entity\PersonnageComment
 * Commentaire sur la fiche d'un personnage
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_PersonnageComment")
 * @ORM\Entity(repositoryClass="Urbicande\PersoBundle\Entity\PersonnageCommentRepository")
 */
class PersonnageComment
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
     * @var Urbicande\UserBundle\Entity\User $user
     * Commentateur
     *
     * @ORM\ManyToOne(targetEntity="Urbicande\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string $comment
     * Texte du commentaire
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var  Personnage $perso
     * Personnage commenté
     * 
     * @ORM\ManyToOne(targetEntity="Personnage", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $perso;

    /**
     * @var  PersonnageComment $parent_comment
     * PersonnageComment commenté
     * 
     * @ORM\ManyToOne(targetEntity="PersonnageComment", inversedBy="answers")
     */
    private $parent_comment;

    /**
     * @var  PersonnageComment $answers
     * PersonnageComment commenté
     * 
     * @ORM\OneToMany(targetEntity="PersonnageComment", mappedBy="parent_comment")
     */
    private $answers;

    /**
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
 
   /**
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

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
     * Set user
     *
     * @param Urbicande\UserBundle\Entity\User $user
     * @return Comments
     */
    public function setUser(\Urbicande\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Urbicande\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set perso
     *
     * @param Personnage $perso
     * @return PersonnageComments
     */
    public function setPerso(Personnage $perso)
    {   
        $this->perso = $perso;
    
        return $this;
    }

    /**
     * Get perso
     *
     * @return Personnage 
     */
    public function getPerso()
    {
        return $this->perso;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return PersonnageComment
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return PersonnageComment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Overrides default toString behaviour
     * @return string
     */
    public function __toString()
    {
        return 'un commentaire sur le personnage '.$this->perso;
    }

    /**
     * Get parent (alias for getPerso())
     * @return Personnage
     */
    public function getParent()
    {
        return $this->perso;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set parent_comment
     *
     * @param \Urbicande\PersoBundle\Entity\PersonnageComment $parentComment
     * @return PersonnageComment
     */
    public function setParentComment(\Urbicande\PersoBundle\Entity\PersonnageComment $parentComment = null)
    {
        $this->parent_comment = $parentComment;
    
        return $this;
    }

    /**
     * Get parent_comment
     *
     * @return \Urbicande\PersoBundle\Entity\PersonnageComment 
     */
    public function getParentComment()
    {
        return $this->parent_comment;
    }

    /**
     * Add answers
     *
     * @param \Urbicande\PersoBundle\Entity\PersonnageComment $answers
     * @return PersonnageComment
     */
    public function addAnswer(\Urbicande\PersoBundle\Entity\PersonnageComment $answers)
    {
        $this->answers[] = $answers;
    
        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Urbicande\PersoBundle\Entity\PersonnageComment $answers
     */
    public function removeAnswer(\Urbicande\PersoBundle\Entity\PersonnageComment $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}