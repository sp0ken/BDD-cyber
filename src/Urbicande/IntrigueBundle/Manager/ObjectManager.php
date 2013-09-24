<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class ObjectManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadObject($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Object entity
     *
     * @param Object $object
     */
    public function saveObject(\Urbicande\IntrigueBundle\Entity\Object $object)
    {
        $object->setOrigin();
        $this->persistAndFlush($object);
    }

    /**
     * Remove Object entity
     *
     * @param Object $object 
     */
    public function removeObject(\Urbicande\IntrigueBundle\Entity\Object $object)
    {
        $this->removeAndFlush($object);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Object');
    }

}