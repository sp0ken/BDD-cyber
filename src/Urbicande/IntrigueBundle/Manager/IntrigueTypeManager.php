<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class IntrigueTypeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadIntrigueType($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save IntrigueType entity
     *
     * @param IntrigueType $intrigueType
     * @param Intrigue $intrigue
     * @param User $user
     */
    public function saveIntrigueType(\Urbicande\IntrigueBundle\Entity\IntrigueType $intrigueType, \Urbicande\IntrigueBundle\Entity\Intrigue $intrigue = null, \Urbicande\UserBundle\Entity\User $user = null)
    {
        if($intrigue) $intrigueType->setIntrigue($intrigue);
        if($user) $intrigueType->setUser($user);

        $this->persistAndFlush($intrigueType);
    }

    /**
     * Remove IntrigueType entity
     *
     * @param IntrigueType $intrigueType 
     */
    public function removeIntrigueType(\Urbicande\IntrigueBundle\Entity\IntrigueType $intrigueType)
    {
        $this->removeAndFlush($intrigueType);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:IntrigueType');
    }

}