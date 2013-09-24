<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class ImplicationManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadImplication($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Implication entity
     *
     * @param Implication $implication 
     */
    public function saveImplication(\Urbicande\IntrigueBundle\Entity\Implication $implication)
    {
        $this->persistAndFlush($implication);
    }

    /**
     * Remove Implication entity
     *
     * @param Implication $implication 
     */
    public function removeImplication(\Urbicande\IntrigueBundle\Entity\Implication $implication)
    {
        $this->removeAndFlush($implication);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Implication');
    }

}