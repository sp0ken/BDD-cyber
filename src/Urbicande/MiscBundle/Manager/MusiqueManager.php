<?php

namespace Urbicande\MiscBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\MiscBundle\Manager\BaseManager;

class MusiqueManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadMusique($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Musique entity
     *
     * @param Musique $musique
     */
    public function saveMusique(\Urbicande\MiscBundle\Entity\Musique $musique)
    {
        $this->persistAndFlush($musique);
    }

    /**
     * Remove Musique entity
     *
     * @param Musique $musique 
     */
    public function removeMusique(\Urbicande\MiscBundle\Entity\Musique $musique)
    {
        $this->removeAndFlush($musique);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeMiscBundle:Musique');
    }

}