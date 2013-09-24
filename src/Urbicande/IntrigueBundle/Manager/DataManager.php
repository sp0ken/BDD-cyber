<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class DataManager extends BaseManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadData($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Data entity
     *
     * @param Data $data 
     */
    public function saveData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $this->persistAndFlush($data);
    }

    /**
     * Remove Data entity
     *
     * @param Data $data 
     */
    public function removeData(\Urbicande\IntrigueBundle\Entity\Data $data)
    {
        $this->removeAndFlush($data);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Data');
    }

}