<?php

namespace Urbicande\MiscBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\MiscBundle\Manager\BaseManager;

class TaskManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadTask($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Task entity
     *
     * @param Task $Task
     */
    public function saveTask(\Urbicande\MiscBundle\Entity\Task $Task)
    {
        $this->persistAndFlush($Task);
    }

    /**
     * Remove Task entity
     *
     * @param Task $Task 
     */
    public function removeTask(\Urbicande\MiscBundle\Entity\Task $Task)
    {
        $this->removeAndFlush($Task);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeMiscBundle:Task');
    }

}