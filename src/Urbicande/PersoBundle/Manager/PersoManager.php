<?php

namespace Urbicande\PersoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\PersoBundle\Manager\BaseManager;

class PersoManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadPerso($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Creates a json table of all events for each personnage
     * @param  Router $router
     * @return JSON         Formatted json
     */
    public function getJsonEvents(Router $router)
    {
      $json = array();
      foreach ($this->loadAll() as $pKey => $perso) {
        foreach ($perso->getEvents() as $key => $event) {
          $json[$key]['start'] = $event->getStartDate()->format('Y-m-d');
          $json[$key]['end'] = $event->getEndDate() ? $event->getEndDate()->format('Y-m-d') : '';
          $json[$key]['content'] = '<a href="'.$router->generate('event_by_id', array('id'=> $event->getId())).'">'.$event->getName().'</a>';
          $json[$key]['group'] = '<a href="'.$router->generate('perso_by_id', array('id'=> $perso->getId())).'">'.$perso.'</a>';
        }
      }
      return json_encode($json);
    }

    /**
     * Creates a json table of all events for each personnage
     * @return JSON         Formatted json
     */
    public function getJsonRelations()
    {
      $json = array();
      foreach ($this->loadAll() as $pKey => $perso) {
        $json[$pKey ]['id'] = (String)$perso->getId();
        $json[$pKey ]['name'] = $perso->getName();

        $json[$pKey ]['data']['$dim'] = 20;
        if($perso->getType() == 'PJ') {
          $json[$pKey ]['data']['$type'] = 'circle';
          $json[$pKey ]['data']['$color'] = '#d70e2b';
        } else if($perso->getType() == 'PNJ') {
          $json[$pKey ]['data']['$type'] = 'square';
          $json[$pKey ]['data']['$color'] = '#3ed70e';
        } else {
          $json[$pKey ]['data']['$type'] = 'triangle';
          $json[$pKey ]['data']['$color'] = '#FFF';
        }

        foreach ($perso->getRelationsTo() as $key => $relation) {
          $json[$pKey]['adjacencies'][$key]['nodeTo'] = (String)$relation->getKnowee()->getId();
          $json[$pKey]['adjacencies'][$key]['nodeFrom'] = (String)$relation->getKnower()->getId();
        }
      }
      return json_encode($json);
    }

    /**
     * Save Perso entity
     *
     * @param Perso $perso 
     */
    public function savePerso(\Urbicande\PersoBundle\Entity\Personnage $perso)
    { 
        $this->persistAndFlush($perso);
    }

    /**
     * Remove Perso entity
     *
     * @param Perso $perso 
     */
    public function removePerso(\Urbicande\PersoBundle\Entity\Personnage $perso)
    {
        $this->removeAndFlush($perso);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandePersoBundle:Personnage');
    }

}