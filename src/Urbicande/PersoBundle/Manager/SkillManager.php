<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class SkillManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadSkill($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save Skill entity
     *
     * @param Skill $skill 
     */
    public function saveSkill(\Urbicande\PersoBundle\Entity\Skill $skill)
    {
        $this->persistAndFlush($skill);
    }

    /**
     * Remove Skill entity
     *
     * @param Skill $skill 
     */
    public function removeSkill(\Urbicande\PersoBundle\Entity\Skill $skill)
    {
        $this->removeAndFlush($skill);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:Skill');
    }

}