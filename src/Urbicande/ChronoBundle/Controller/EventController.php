<?php

namespace Urbicande\ChronoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\ChronoBundle\Entity\Event;
use Urbicande\ChronoBundle\Form\EventType;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Liste les événements
     */
    public function indexAction()
    {
        $events = $this->get('urbicande.event_manager')->loadAll();

        return $this->render('UrbicandeChronoBundle:Event:index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Affiche un événement
     */
    public function showAction($id)
    {
        $event = $this->get('urbicande.event_manager')->loadEvent($id);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        return $this->render('UrbicandeChronoBundle:Event:show.html.twig', array(
            'event'      => $event,
        ));
    }

    /**
     * Créer un événement
     */
    public function createAction(Request $request)
    {
        $event  = new Event();
        $form = $this->createForm(new EventType(), $event);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.event_manager')->saveEvent($event);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un évènement', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'L‘évènement a été créé');
            return $this->redirect($this->generateUrl('event_by_id', array('id' => $event->getId())));
        }

        return $this->render('UrbicandeChronoBundle:Event:new.html.twig', array(
            'event' => $event,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Page d'édition d'un événement
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->get('urbicande.event_manager')->loadEvent($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($event);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createForm(new EventType(), $event);

        return $this->render('UrbicandeChronoBundle:Event:edit.html.twig', array(
            'logs' => $logs,
            'event'      => $event,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Reverts this event to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $event = $em->find('Urbicande\ChronoBundle\Entity\Event', $id);
        $version = $request->get('version');

        $repo->revert($event, intval($version));
        $em->persist($event);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'L\'évènement a été restauré');
        return $this->redirect($this->generateUrl('event_by_id', array('id' => $id)));
    }

    /**
     * Enregistrement de l'édition d'un évènement
     */
    public function updateAction(Request $request, $id)
    {
        $event = $this->get('urbicande.event_manager')->loadEvent($id);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createForm(new EventType(), $event);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.event_manager')->saveEvent($event);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un évènement', $this->container->getParameter('supervisor_email'));

            $this->get('session')->getFlashBag()->add('update', 'L‘évènement a été mis à jour');
            return $this->redirect($this->generateUrl('event_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeChronoBundle:Event:edit.html.twig', array(
            'event'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Supprime un évènement
     */
    public function deleteAction($id)
    {
      $event = $this->get('urbicande.event_manager')->loadEvent($id);

      if (!$event) {
          throw $this->createNotFoundException('Unable to find Event entity.');
      }

      $this->get('urbicande.event_manager')->removeEvent($event);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un évènement', $this->container->getParameter('supervisor_email'));

      $this->get('session')->getFlashBag()->add('delete', 'L‘évènement a été supprimé');
      return $this->redirect($this->generateUrl('event_list'));
    }

    /**
     * Affiche les chronologies de chaque personnages
     */
    public function persoChronoAction()
    {
      $persos = $this->get('urbicande.perso_manager')->loadAll();

      return $this->render('UrbicandeChronoBundle:Event:perso.html.twig', array(
          'persos'      => $persos,
      ));
    }

    /**
     * Affiche les chronologies de chaque groupes
     */
    public function groupeChronoAction()
    {
      $groupes = $this->get('urbicande.groupe_manager')->loadAll();

      return $this->render('UrbicandeChronoBundle:Event:groupe.html.twig', array(
          'groupes'      => $groupes,
      ));
    }

    /**
     * Affiche les chronologies de chaque intrigues
     */
    public function intrigueChronoAction()
    {
      $intrigues = $this->get('urbicande.intrigue_manager')->loadAll();

      return $this->render('UrbicandeChronoBundle:Event:intrigue.html.twig', array(
          'intrigues'      => $intrigues,
      ));
    }
}
