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
     * Liste les événements de scénographie
     */
    public function indexAction()
    {
      $scenos = $this->get('urbicande.sceno_manager')->loadAll();

      return $this->render('UrbicandeChronoBundle:Sceno:index.html.twig', array(
          'scenos' => $scenos,
      ));
    }

    /**
     * Affiche les évènement de scénographie
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
     * Créer un évènement de scénographie
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
     * Page d'édition d'un évènement de scénographie
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $sceno = $this->get('urbicande.sceno_manager')->loadSceno($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($sceno);

        if (!$sceno) {
            throw $this->createNotFoundException('Unable to find Sceno entity.');
        }

        $editForm = $this->createForm(new ScenoType(), $sceno);

        return $this->render('UrbicandeChronoBundle:Sceno:edit.html.twig', array(
            'logs' => $logs,
            'sceno'      => $sceno,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Reverts this sceno to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $sceno = $em->find('Urbicande\ChronoBundle\Entity\Sceno', $id);
        $version = $request->get('version');

        $repo->revert($sceno, intval($version));
        $em->persist($sceno);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'L\'évènement de scénographie a été restauré');
        return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $id)));
    }

    /**
     * Enregistrement de l'édition d'un évènement de scénographie
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
     * Supprime un évènement de scénographie
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
     * Supprime un timing d'un évènement de scénographie
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
     * Requête ajax pour récupérer tous les évènements de scénographie en json
     * @return JsonReponse
     */
    public function calendarAction()
    {
      $response = new JsonResponse();
      $response->setData($this->get('urbicande.sceno_manager')->getJson($this->get('router')));
      return $response;
    }

    /**
     * Supprime un objet de l'évènement de scénographie donné
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

      $sceno->removeObject($object);
      $this->get('urbicande.sceno_manager')->saveSceno($sceno);
      
      $this->get('session')->getFlashBag()->add('delete', $object.' n‘est plus requis pour la scéno');
      return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $sceno->getId())));
    }

     /**
     * Supprime un objet de l'évènement de scénographie donné
     */
    public function removePersoAction($scenoId, $persoId)
    {
      $sceno = $this->get('urbicande.sceno_manager')->loadSceno($scenoId);
      $perso = $this->get('urbicande.perso_manager')->loadperso($persoId);

      if (!$sceno) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }
      if (!$perso) {
          throw $this->createNotFoundException('Unable to find perso entity.');
      }

      $sceno->removePlayer($perso);
      $this->get('urbicande.sceno_manager')->saveSceno($sceno);
      
      $this->get('session')->getFlashBag()->add('delete', $perso.' n‘est plus requis pour la scéno');
      return $this->redirect($this->generateUrl('sceno_by_id', array('id' => $sceno->getId())));
    }
}
