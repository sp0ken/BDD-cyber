<?php

namespace Urbicande\ChronoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbicande\ChronoBundle\Entity\Sceno;
use Urbicande\ChronoBundle\Form\ScenoType;

/**
 * Sceno controller.
 *
 */
class ScenoController extends Controller
{
    /**
     * Lists all Sceno entities.
     *
     */
    public function indexAction()
    {
      $scenos = $this->get('urbicande.sceno_manager')->loadAll();

      return $this->render('UrbicandeChronoBundle:Sceno:index.html.twig', array(
          'scenos' => $scenos,
      ));
    }

    /**
     * Finds and displays a Sceno entity.
     *
     */
    public function showAction($id)
    {
        $sceno = $this->get('urbicande.sceno_manager')->loadSceno($id);

        if (!$sceno) {
            throw $this->createNotFoundException('Unable to find Sceno entity.');
        }

        return $this->render('UrbicandeChronoBundle:Sceno:show.html.twig', array(
          'sceno'      => $sceno,
        ));
    }

    /**
     * Creates a new Sceno entity.
     *
     */
    public function createAction(Request $request)
    {
        $sceno  = new Sceno();
        $form = $this->createForm(new ScenoType(), $sceno);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.sceno_manager')->saveSceno($sceno);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une scénographie', $this->container->getParameter('supervisor_email'));

            $this->get('session')->getFlashBag()->add('create', 'L‘évènement de scénographie a été créé');
            return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $sceno->getId())));
        }

        return $this->render('UrbicandeChronoBundle:Sceno:new.html.twig', array(
            'sceno' => $sceno,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sceno entity.
     *
     */
    public function editAction($id)
    {
        $sceno = $this->get('urbicande.sceno_manager')->loadSceno($id);

        if (!$sceno) {
            throw $this->createNotFoundException('Unable to find Sceno entity.');
        }

        $editForm = $this->createForm(new ScenoType(), $sceno);

        return $this->render('UrbicandeChronoBundle:Sceno:edit.html.twig', array(
            'sceno'      => $sceno,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Sceno entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $sceno = $this->get('urbicande.sceno_manager')->loadSceno($id);

        if (!$sceno) {
            throw $this->createNotFoundException('Unable to find Sceno entity.');
        }

        $editForm = $this->createForm(new ScenoType(), $sceno);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.sceno_manager')->saveSceno($sceno);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une scénographie', $this->container->getParameter('supervisor_email'));

            $this->get('session')->getFlashBag()->add('update', 'L‘évènement de scénographie a été mis à jour');
            return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeChronoBundle:Sceno:edit.html.twig', array(
          'sceno'      => $sceno,
          'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Sceno entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      $sceno = $this->get('urbicande.sceno_manager')->loadSceno($id);

      if (!$sceno) {
          throw $this->createNotFoundException('Unable to find Sceno entity.');
      }

      $this->get('urbicande.sceno_manager')->removeSceno($sceno);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé une scénographie', $this->container->getParameter('supervisor_email'));

      $this->get('session')->getFlashBag()->add('delete', 'L‘évènement de scénographie a été supprimé');
      return $this->redirect($this->generateUrl('sceno_list'));
    }

    /**
     * Deletes a timing from a sceno entity.
     *
     */
    public function deleteTimingAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('UrbicandeChronoBundle:Timing')->find($id);
      $sceno = $entity->getSceno();

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find Timing entity.');
      }

      $em->remove($entity);
      $em->flush();

      $this->get('session')->getFlashBag()->add('delete', 'Le timing a été supprimé');
      return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $sceno->getId())));
    }

    /**
     * Ajax request to get all scenographie events in json format
     * @return JsonReponse
     */
    public function calendarAction()
    {
      $response = new JsonResponse();
      $response->setData($this->get('urbicande.sceno_manager')->getJson($this->get('router')));
      return $response;
    }

    /**
     * Remove a given data from a given knower.
     *
     */
    public function removeObjectAction($scenoId, $objectId)
    {
      $sceno = $this->get('urbicande.sceno_manager')->loadSceno($scenoId);
      $object = $this->get('urbicande.object_manager')->loadObject($objectId);

      if (!$sceno) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }
      if (!$object) {
          throw $this->createNotFoundException('Unable to find Object entity.');
      }

      $entity->removeObject($object);
      $this->get('urbicande.sceno_manager')->saveSceno($sceno);
      
      $this->get('session')->getFlashBag()->add('delete', $object.' n‘est plus requis pour la scéno');
      return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $sceno->getId())));
    }
}
