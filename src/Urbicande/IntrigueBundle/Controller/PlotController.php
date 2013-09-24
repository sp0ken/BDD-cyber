<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Plot;
use Urbicande\IntrigueBundle\Form\PlotType;

/**
 * Plot controller.
 *
 */
class PlotController extends Controller
{
    /**
     * Remove a data from the chosen plot.
     *
     */
    public function removeDataAction($plotId, $dataId)
    {
        $plot = $this->get('urbicande.plot_manager')->loadPlot($plotId);
        $data = $this->get('urbicande.data_manager')->loadData($dataId);

        if (!$plot) {
            throw $this->createNotFoundException('Unable to find Plot entity.');
        }
        if (!$data) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        $plot->removeData($data);
        $this->get('urbicande.plot_manager')->savePlot($plot);
        
        $this->get('session')->getFlashBag()->add('delete', 'La donnée a été enlevée de l‘intrigue');
        return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $entity->getIntrigue()->getId())));
    }
}
