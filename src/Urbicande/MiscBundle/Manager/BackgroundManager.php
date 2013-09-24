<?php

namespace Urbicande\MiscBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\MiscBundle\Manager\BaseManager;

class BackgroundManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadBackground($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Background entity
     *
     * @param Background $background
     */
    public function saveBackground(\Urbicande\MiscBundle\Entity\Background $background)
    {
        $this->persistAndFlush($background);
    }

    /**
     * Remove Background entity
     *
     * @param Background $background 
     */
    public function removeBackground(\Urbicande\MiscBundle\Entity\Background $background)
    {
        $this->removeAndFlush($background);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeMiscBundle:Background');
    }

}