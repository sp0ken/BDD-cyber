<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class LevelManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadLevel($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save Level entity
     *
     * @param Level $level
     */
    public function saveLevel(\Urbicande\PersoBundle\Entity\Level $level)
    {
        $this->persistAndFlush($level);
    }

    /**
     * Remove Level entity
     *
     * @param Level $level 
     */
    public function removeLevel(\Urbicande\PersoBundle\Entity\Level $level)
    {
        $this->removeAndFlush($level);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:Level');
    }

}