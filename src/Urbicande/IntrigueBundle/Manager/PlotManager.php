<?php

namespace Urbicande\IntrigueBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\IntrigueBundle\Manager\BaseManager;

class PlotManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadPlot($id) {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function loadAll() {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Save Plot entity
     *
     * @param Plot $plot
     */
    public function savePlot(\Urbicande\IntrigueBundle\Entity\Plot $plot)
    {
        $this->persistAndFlush($plot);
    }

    /**
     * Remove Plot entity
     *
     * @param Plot $plot 
     */
    public function removePlot(\Urbicande\IntrigueBundle\Entity\Plot $plot)
    {
        $this->removeAndFlush($plot);
    }

    public function getRepository()
    {
        return $this->em->getRepository('UrbicandeIntrigueBundle:Plot');
    }

}