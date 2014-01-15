<?php

namespace Urbicande\MiscBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Statistics controller.
 *
 */
class StatsController extends Controller
{
    /**
     *
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $genderChart = $em->getRepository('UrbicandePersoBundle:Personnage')->countGender();
        var_dump($genderChart);
        die();
        return $this->render('UrbicandeMiscBundle:Stats:index.html.twig', array(
            'chart' => $chart,
        ));
    }

    
}
