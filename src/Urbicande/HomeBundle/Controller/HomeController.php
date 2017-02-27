<?php

namespace Urbicande\HomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Urbicande\MiscBundle\Entity\Task;
use Urbicande\MiscBundle\Form\TaskType;

class HomeController extends Controller
{
    
    /**
     * Homepage
     */
    public function indexAction()
    {
      $log_manager = $this->get('urbicande.log_manager');
      $logs = $log_manager->format($log_manager->loadHome());
      
      $task  = new Task();
      $task->setWriter($this->getUser());
      $form = $this->createForm(new TaskType(), $task);

      return $this->render('UrbicandeHomeBundle:Home:index.html.twig', array(
        'logs' => $logs,
        'taskForm' => $form->createView()
      ));
    }

    /**
     * Logs page
     */
    public function logAction()
    {
      $log_manager = $this->get('urbicande.log_manager');
      $logs = $log_manager->format($log_manager->loadAll());

      return $this->render('UrbicandeHomeBundle:Home:log.html.twig', array(
        'logs' => $logs
      ));
    }

    public function saveResizeAction(Request $request)
    {
      if($request->isXmlHttpRequest())  {
        $response = new JsonResponse();
        try {
          $userManager = $this->container->get('fos_user.user_manager');
          $user = $this->getUser();
          $setting = $user->getSetting();

          switch ($request->get('block')) {
            case 'rpg':
              $setting->setRpgSize($request->get('size'));
              break;
            case 'log':
              $setting->setLogSize($request->get('size'));
              break;
            case 'my-plots':
              $setting->setPlotSize($request->get('size'));
              break;
            case 'my-players':
              $setting->setPersoSize($request->get('size'));
              break;
            case 'my-groups':
              $setting->setGroupeSize($request->get('size'));
              break;
            case 'my-rules':
              $setting->setRuleSize($request->get('size'));
              break;
            case 'my-skills':
              $setting->setSkillSize($request->get('size'));
              break;
            case 'my-tasks':
              $setting->setTaskSize($request->get('size'));
              break;
          }

          $userManager->updateUser($user);
          $response->setData(array('result' => 'ok'));
        } catch (Exception $e) {
          $response->setData(array('result' => $e));
        }

        return $response;
      }
    }

    public function saveOrderAction(Request $request)
    {
      if($request->isXmlHttpRequest())  {
        $response = new JsonResponse();
        try {
          $userManager = $this->container->get('fos_user.user_manager');
          $user = $this->getUser();
          $setting = $user->getSetting();
          $setting->setBlockOrder($request->get('order'));

          $userManager->updateUser($user);
          $response->setData(array('result' => 'ok'));
        } catch (Exception $e) {
          $response->setData(array('result' => $e));
        }

        return $response;
      }
    }
}
