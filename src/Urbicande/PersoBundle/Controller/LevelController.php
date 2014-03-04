<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\Level;
use Urbicande\PersoBundle\Form\LevelType;

/**
 * Level controller.
 *
 */
class LevelController extends Controller
{
    /**
     * Lists all Level entities.
     *
     */
    public function indexAction()
    {
        $levels = $this->get('urbicande.level_manager')->loadAll();

        return $this->render('UrbicandePersoBundle:Level:index.html.twig', array(
            'levels' => $levels,
        ));
    }

    /**
     * Finds and displays a Level entity.
     *
     */
    public function showAction($id)
    {
        $level = $this->get('urbicande.level_manager')->loadLevel($id);

        if (!$level) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        return $this->render('UrbicandePersoBundle:Level:show.html.twig', array(
            'level'      => $level,
        ));
    }

    /**
     * Creates a new Level entity.
     *
     */
    public function createAction(Request $request)
    {
        $level  = new Level();
        $form = $this->createForm(new LevelType(), $level);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.level_manager')->saveLevel($level);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un niveau', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le niveau a été créé');
            return $this->redirect($this->generateUrl('level_by_id', array('id' => $level->getId())));
        }

        return $this->render('UrbicandePersoBundle:Level:new.html.twig', array(
            'entity' => $level,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Level entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $level = $this->get('urbicande.level_manager')->loadLevel($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $levelBackup = $em->find('Urbicande\PersoBundle\Entity\Level', $id);
        $logs = $repo->getLogEntries($levelBackup);

        if (!$level) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $editForm = $this->createForm(new LevelType(), $level);

        return $this->render('UrbicandePersoBundle:Level:edit.html.twig', array(
            'logs'    => $logs,
            'level'   => $level,
            'form'    => $editForm->createView(),
        ));
    }

    /**
     * Reverts this evel to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $level = $em->find('Urbicande\PersoBundle\Entity\Level', $id);
        $version = $request->get('version');

        $repo->revert($level, intval($version));
        $em->persist($level);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le niveau a été restauré');
        return $this->redirect($this->generateUrl('level_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Level entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $level = $this->get('urbicande.level_manager')->loadLevel($id);

        if (!$level) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $editForm = $this->createForm(new LevelType(), $level);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.level_manager')->saveLevel($level);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un niveau', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le niveau a été mis à jour');
            return $this->redirect($this->generateUrl('level_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:Level:edit.html.twig', array(
            'entity'      => $level,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Level entity.
     *
     */
    public function deleteAction($id)
    {
      $level = $this->get('urbicande.level_manager')->loadLevel($id);

      if (!$level) {
          throw $this->createNotFoundException('Unable to find Level entity.');
      }

      $this->get('urbicande.level_manager')->removeLevel($type);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un niveau', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('delete', 'Le niveau a été supprimé');
      return $this->redirect($this->generateUrl('level_list'));
    }

}
