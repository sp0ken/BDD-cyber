<?php

namespace Urbicande\ChronoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\ChronoBundle\Manager\BaseManager;

class EventManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadEvent($eventId) {
        return $this->getRepository()->findOneBy(array('id' => $eventId));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * Save Event entity
     *
     * @param Event $event 
     */
    public function saveEvent(\Urbicande\ChronoBundle\Entity\Event $event)
    {
        $this->persistAndFlush($event);
    }

    /**
     * Remove Event entity
     *
     * @param Event $event 
     */
    public function removeEvent(\Urbicande\ChronoBundle\Entity\Event $event)
    {
        $this->removeAndFlush($event);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeChronoBundle:Event');
    }

}