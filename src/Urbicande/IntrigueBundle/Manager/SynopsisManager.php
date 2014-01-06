<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class SynopsisManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadSynopsis($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Synopsis entity
     *
     * @param Synopsis $synopsis
     */
    public function saveSynopsis(\Urbicande\IntrigueBundle\Entity\Synopsis $synopsis)
    {
        $this->persistAndFlush($synopsis);
    }

    /**
     * Remove Synopsis entity
     *
     * @param Synopsis $synopsis 
     */
    public function removeSynopsis(\Urbicande\IntrigueBundle\Entity\Synopsis $synopsis)
    {
        $this->removeAndFlush($synopsis);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Synopsis');
    }

}