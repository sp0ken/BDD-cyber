<?php

namespace Urbicande\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    
    public function indexAction()
    {
      $log_manager = $this->get('urbicande.log_manager');
      $logs = $log_manager->format($log_manager->loadHome());

      return $this->render('UrbicandeHomeBundle:Home:index.html.twig', array(
        'logs' => $logs
      ));
    }

    public function logAction()
    {
      $log_manager = $this->get('urbicande.log_manager');
      $logs = $log_manager->format($log_manager->loadAll());

      return $this->render('UrbicandeHomeBundle:Home:log.html.twig', array(
        'logs' => $logs
      ));
    }
}
