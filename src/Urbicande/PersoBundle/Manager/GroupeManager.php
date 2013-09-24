<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class GroupeManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadGroupe($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    public function getJsonEvents(Router $router)
    {
      $json = array();
      foreach ($this->loadAll() as $pKey => $groupe) {
        foreach ($groupe->getEvents() as $key => $event) {
          $json[$key]['start'] = $event->getStartDate()->format('Y-m-d');
          $json[$key]['end'] = $event->getEndDate() ? $event->getEndDate()->format('Y-m-d') : '';
          $json[$key]['content'] = '<a href="'.$router->generate('event_by_id', array('id'=> $event->getId())).'">'.$event->getName().'</a>';
          $json[$key]['group'] = '<a href="'.$router->generate('perso_by_id', array('id'=> $groupe->getId())).'">'.$groupe.'</a>';
        }
      }
      return json_encode($json);
    }

    /**
     * Save Groupe entity
     *
     * @param Groupe $groupe 
     */
    public function saveGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        $this->persistAndFlush($groupe);
    }

    /**
     * Remove Groupe entity
     *
     * @param Groupe $groupe 
     */
    public function removeGroupe(\Urbicande\PersoBundle\Entity\Groupe $groupe)
    {
        $this->removeAndFlush($groupe);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:Groupe');
    }

}