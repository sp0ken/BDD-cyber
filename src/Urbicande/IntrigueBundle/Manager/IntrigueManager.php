<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class IntrigueManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadIntrigue($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Intrigue entity
     *
     * @param Intrigue $intrigue
     */
    public function saveIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->persistAndFlush($intrigue);
    }

    /**
     * Remove Intrigue entity
     *
     * @param Intrigue $intrigue 
     */
    public function removeIntrigue(\Urbicande\IntrigueBundle\Entity\Intrigue $intrigue)
    {
        $this->removeAndFlush($intrigue);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Intrigue');
    }

}