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
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {
        $events = $this->get('urbicande.event_manager')->loadAll();

        return $this->render('UrbicandeChronoBundle:Event:index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
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
     * Creates a new Event entity.
     *
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
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction($id)
    {
        $event = $this->get('urbicande.event_manager')->loadEvent($id);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createForm(new EventType(), $event);

        return $this->render('UrbicandeChronoBundle:Event:edit.html.twig', array(
            'event'      => $event,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Event entity.
     *
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
     * Deletes a Event entity.
     *
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
