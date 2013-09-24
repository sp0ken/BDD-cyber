<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class ObjectTypeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadObjectType($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save ObjectType entity
     *
     * @param ObjectType $objectType
     */
    public function saveObjectType(\Urbicande\IntrigueBundle\Entity\ObjectType $objectType)
    {
        $this->persistAndFlush($objectType);
    }

    /**
     * Remove ObjectType entity
     *
     * @param ObjectType $objectType 
     */
    public function removeObjectType(\Urbicande\IntrigueBundle\Entity\ObjectType $objectType)
    {
        $this->removeAndFlush($objectType);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:ObjectType');
    }

}