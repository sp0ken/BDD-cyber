<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class RuleManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadRule($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Rule entity
     *
     * @param Rule $rule
     */
    public function saveRule(\Urbicande\IntrigueBundle\Entity\Rule $rule)
    {
        $this->persistAndFlush($rule);
    }

    /**
     * Remove Rule entity
     *
     * @param Rule $rule 
     */
    public function removeRule(\Urbicande\IntrigueBundle\Entity\Rule $rule)
    {
        $this->removeAndFlush($rule);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Rule');
    }

}