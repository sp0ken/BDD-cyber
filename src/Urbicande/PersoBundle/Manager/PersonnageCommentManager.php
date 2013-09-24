<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class PersonnageCommentManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadPersonnageComment($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save PersonnageComment entity
     *
     * @param PersonnageComment $persoComment
     * @param Personnage $perso
     * @param User $user
     */
    public function savePersonnageComment(\Urbicande\PersoBundle\Entity\PersonnageComment $persoComment, \Urbicande\PersoBundle\Entity\Personnage $perso = null, \Urbicande\UserBundle\Entity\User $user = null)
    {
        if($perso) $persoComment->setPerso($perso);
        if($user) $persoComment->setUser($user);

        $this->persistAndFlush($persoComment);
    }

    /**
     * Remove PersonnageComment entity
     *
     * @param PersonnageComment $personnageComment 
     */
    public function removePersonnageComment(\Urbicande\PersoBundle\Entity\PersonnageComment $personnageComment)
    {
        $this->removeAndFlush($personnageComment);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:PersonnageComment');
    }

}