<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class RelationManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadRelation($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Relation entity
     *
     * @param Relation $relation
     */
    public function saveRelation(\Urbicande\PersoBundle\Entity\Relation $relation)
    {
        $this->persistAndFlush($relation);
    }

    /**
     * Remove Relation entity
     *
     * @param Relation $relation 
     */
    public function removeRelation(\Urbicande\PersoBundle\Entity\Relation $relation)
    {
        $this->removeAndFlush($relation);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:Relation');
    }

}