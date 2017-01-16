<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class IntrigueCommentManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadIntrigueComment($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('created_at' => 'DESC'));
    }

    /**
     * Save IntrigueComment entity
     *
     * @param IntrigueComment $intrigueComment
     * @param Intrigue $intrigue
     * @param IntrigueComment $comment
     * @param User $user
     */
    public function saveIntrigueComment(\Urbicande\IntrigueBundle\Entity\IntrigueComment $intrigueComment, \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue = null, \Urbicande\IntrigueBundle\Entity\IntrigueComment $comment = null, \Urbicande\UserBundle\Entity\User $user = null)
    {
        if($intrigue) $intrigueComment->setIntrigue($intrigue);
        if($comment) $intrigueComment->setParentComment($comment);
        if($user) $intrigueComment->setUser($user);

        $this->persistAndFlush($intrigueComment);
    }

    /**
     * Remove IntrigueComment entity
     *
     * @param IntrigueComment $intrigueComment 
     */
    public function removeIntrigueComment(\Urbicande\IntrigueBundle\Entity\IntrigueComment $intrigueComment)
    {
        $this->removeAndFlush($intrigueComment);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:IntrigueComment');
    }

}