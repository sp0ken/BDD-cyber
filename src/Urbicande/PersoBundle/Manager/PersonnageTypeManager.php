<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class PersonnageTypeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadPersonnageType($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save PersonnageType entity
     *
     * @param PersonnageType $persoType
     */
    public function savePersonnageType(\Urbicande\PersoBundle\Entity\PersonnageType $persoType)
    {
        $this->persistAndFlush($persoType);
    }

    /**
     * Remove PersonnageType entity
     *
     * @param PersonnageType $personnageType 
     */
    public function removePersonnageType(\Urbicande\PersoBundle\Entity\PersonnageType $personnageType)
    {
        $this->removeAndFlush($personnageType);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:PersonnageType');
    }

}