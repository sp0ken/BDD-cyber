<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Commentaire d'intrigue
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="cyber_IntrigueComment")
 * @ORM\Entity(repositoryClass="Urbicande\IntrigueBundle\Entity\IntrigueCommentRepository")
 */
class IntrigueComment
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
     * @var  Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * Intrigue commentée
     * 
     * @ORM\ManyToOne(targetEntity="Urbicande\IntrigueBundle\Entity\Intrigue", inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $intrigue;

    /**
     * @var  IntrigueComment $parent_comment
     * IntrigueComment commenté
     * 
     * @ORM\ManyToOne(targetEntity="IntrigueComment", inversedBy="answers")
     */
    private $parent_comment;

    /**
     * @var  IntrigueComment $answers
     * IntrigueComment commenté
     * 
     * @ORM\OneToMany(targetEntity="IntrigueComment", mappedBy="parent_comment")
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
     * @param \stdClass $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
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
     * Set Intrigue
     *
     * @param Urbicande\IntrigueBundle\Entity\Intrigue $intrigue
     * @return Comments
     */
    public function setIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->intrigue = $intrigue;
    
        return $this;
    }

    /**
     * Get Intrigue
     *
     * @return Urbicande\IntrigueBundle\Entity\Intrigue 
     */
    public function getIntrigue()
    {
        return $this->intrigue;
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
     * @return IntrigueComment
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
     */
    public function __toString()
    {
        return 'un commentaire sur l‘intrigue '.$this->intrigue;
    }

    /**
     * Get parent (alias for getIntrigue())
     */
    public function getParent()
    {
        return $this->intrigue;
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
     * @param \Urbicande\IntrigueBundle\Entity\IntrigueComment $parentComment
     * @return IntrigueComment
     */
    public function setParentComment(\Urbicande\IntrigueBundle\Entity\IntrigueComment $parentComment = null)
    {
        $this->parent_comment = $parentComment;
    
        return $this;
    }

    /**
     * Get parent_comment
     *
     * @return \Urbicande\IntrigueBundle\Entity\IntrigueComment 
     */
    public function getParentComment()
    {
        return $this->parent_comment;
    }

    /**
     * Add answers
     *
     * @param \Urbicande\IntrigueBundle\Entity\IntrigueComment $answers
     * @return IntrigueComment
     */
    public function addAnswer(\Urbicande\IntrigueBundle\Entity\IntrigueComment $answers)
    {
        $this->answers[] = $answers;
    
        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Urbicande\IntrigueBundle\Entity\IntrigueComment $answers
     */
    public function removeAnswer(\Urbicande\IntrigueBundle\Entity\IntrigueComment $answers)
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