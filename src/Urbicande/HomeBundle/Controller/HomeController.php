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

    public function createTaskAction(Request $request)
    {
      if($request->isXmlHttpRequest())  {
        $userManager = $this->container->get('fos_user.user_manager');

        $endDate = \DateTime::createFromFormat('d m Y', $request->get('endDay').' '.$request->get('endMonth').' '.$request->get('endYear'));
        $user = $userManager->findUserBy(array('id' => $request->get('writer')));
        
        $task = new Task();
        $task->setWriter($user);
        $task->setText($request->get('text'));
        $task->setEndDate($endDate);
        $task->setIsDone(false);

         $task_manager = $this->get('urbicande.task_manager');
         $task_manager->saveTask($task);
         //
        $response = new JsonResponse();
        $response->setData(array('data' => 'ok'));
        return $response;
      } else {
        return $this->redirect($this->generateUrl('Home'));
      }
    }
}
