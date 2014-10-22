<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class RelationTypeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadRelationType($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save RelationType entity
     *
     * @param RelationType $relationType
     */
    public function saveRelationType(\Urbicande\PersoBundle\Entity\RelationType $relationType)
    {
        $this->persistAndFlush($relationType);
    }

    /**
     * Remove RelationType entity
     *
     * @param RelationType $RelationType 
     */
    public function removeRelationType(\Urbicande\PersoBundle\Entity\RelationType $relationType)
    {
        $this->removeAndFlush($relationType);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:RelationType');
    }

}