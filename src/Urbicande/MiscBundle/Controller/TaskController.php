<?php

namespace Urbicande\MiscBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Urbicande\MiscBundle\Entity\Task;
use Urbicande\MiscBundle\Form\TaskType;

/**
 * task controller.
 *
 */
class TaskController extends Controller
{
    /**
     * Lists all task entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UrbicandeMiscBundle:Task')->findAll();

        return $this->render('UrbicandeMiscBundle:Task:index.html.twig', array(
            'tasks' => $entities,
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find task entity.');
        }

        return $this->render('UrbicandeMiscBundle:Task:show.html.twig', array(
            'task'      => $entity,
        ));
    }

    /**
     * Creates a new task entity.
     *
     */
    public function createAction(Request $request)
    {
      $task  = new Task();
      $task->setIsDone(false);
      $form = $this->createForm(new TaskType(), $task);
      $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->get('session')->getFlashBag()->add('create', 'La tache a été créée');
            return $this->redirect($this->generateUrl('task_list'));
        }

        return $this->render('UrbicandeMiscBundle:Task:new.html.twig', array(
            'task' => $task,
            'form'   => $form->createView(),
        ));
    }

    public function createAJAXTaskAction(Request $request)
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
        $response->setData(array('tache' => $task->__toString()));
        return $response;
      } else {
        return $this->redirect($this->generateUrl('Home'));
      }
    }

    public function completeTaskAction($id)
    {
      $task_manager = $this->get('urbicande.task_manager');
      $task = $task_manager->loadTask($id);
      $task->setIsDone(true);
      $task_manager->saveTask($task);

      $response = new JsonResponse();
      $response->setData(array('result' => 'ok'));
      return $response;
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('UrbicandeMiscBundle:Task')->find($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($task);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find task entity.');
        }

        $editForm = $this->createForm(new taskType(), $task);

        return $this->render('UrbicandeMiscBundle:Task:edit.html.twig', array(
            'task'      => $task,
            'logs'         => $logs,
            'form'   => $editForm->createView(),
        ));
    }

     /**
     * Reverts this task to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $task = $em->find('Urbicande\MiscBundle\Entity\Task', $id);
        $version = $request->get('version');

        $repo->revert($task, intval($version));
        $em->persist($task);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'La tache a été restaurée');
        return $this->redirect($this->generateUrl('task_list'));
    }

    /**
     * Edits an existing task entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find task entity.');
        }

        $editForm = $this->createForm(new taskType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'La tache a été mis à jour');
            return $this->redirect($this->generateUrl('task_list'));
        }

        return $this->render('UrbicandeMiscBundle:Task:edit.html.twig', array(
            'task'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a task entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $back = $this->get('urbicande.task_manager')->loadtask($id);

        if (!$back) {
          throw $this->createNotFoundException('Unable to find task entity.');
        }

        $this->get('urbicande.task_manager')->removetask($back);

        $this->get('session')->getFlashBag()->add('delete', 'La tache a été supprimée');
        return $this->redirect($this->generateUrl('task_list'));
    }

}
