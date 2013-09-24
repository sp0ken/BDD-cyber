<?php

namespace Urbicande\ChronoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\ChronoBundle\Manager\BaseManager;

class ScenoManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadSceno($scenoId) {
        return $this->getRepository()->findOneBy(array('id' => $scenoId));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Returns all sceno in a formatted array
     * @param  Router $routing Router service
     * @return array
     */
    public function getJson(\Symfony\Bundle\FrameworkBundle\Routing\Router $routing)
    {
      $scenos = $this->loadAll();
      $cal = array();
      foreach ($scenos as $key => $sceno) {
        foreach ($sceno->getTimings() as $key => $timing) {
          $start = new \DateTime;
          $start->add(new \DateInterval('P'.($timing->getStartDay()-1).'D'));
          $start->setTime($timing->getStartHour()->format('H'), $timing->getStartHour()->format('i'));
          
          $event = array();
          $event['id'] = $sceno->getId();
          $event['title'] = $sceno->getName();
          $event['allDay'] = false;
          $event['start'] = $start->format('Y-m-d H:i:s');
          if($timing->getEndDay()){
            $end = new \DateTime;
            $end->add(new \DateInterval('P'.($timing->getEndDay()-1).'D'));
            $end->setTime($timing->getEndHour()->format('H'), $timing->getEndHour()->format('i'));
            $event['end'] = $end->format('Y-m-d H:i:s');
          }
          $event['url'] = $routing->generate('sceno_by_id', array('id' => $sceno->getId()));
          $cal[] = $event;
        }
      }
      return $cal;
    }

    /**
     * Save Sceno entity
     *
     * @param Sceno $sceno 
     */
    public function saveSceno(\Urbicande\ChronoBundle\Entity\Sceno $sceno)
    {
        $this->persistAndFlush($sceno);
    }

    /**
     * Remove Sceno entity
     *
     * @param Sceno $sceno 
     */
    public function removeSceno(\Urbicande\ChronoBundle\Entity\Sceno $sceno)
    {
        $this->removeAndFlush($sceno);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeChronoBundle:Sceno');
    }

}