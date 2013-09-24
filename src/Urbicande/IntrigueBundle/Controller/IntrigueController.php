<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Intrigue;
use Urbicande\IntrigueBundle\Form\IntrigueType;

/**
 * Intrigue controller.
 *
 */
class IntrigueController extends Controller
{
    /**
     * Lists all Intrigue entities.
     *
     */
    public function indexAction()
    {
      $intrigues = $this->get('urbicande.intrigue_manager')->loadAll();

      return $this->render('UrbicandeIntrigueBundle:Intrigue:index.html.twig', array(
          'intrigues' => $intrigues,
      ));
    }

    /**
     * Finds and displays a Intrigue entity.
     *
     */
    public function showAction($id)
    {
      $intrigue = $this->get('urbicande.intrigue_manager')->loadIntrigue($id);

      if (!$intrigue) {
          throw $this->createNotFoundException('Unable to find Intrigue entity.');
      }

      return $this->render('UrbicandeIntrigueBundle:Intrigue:show.html.twig', array(
          'intrigue'      => $intrigue,
      ));
    }

    /**
     * Creates a new Intrigue entity.
     *
     */
    public function createAction(Request $request)
    {
      $intrigue  = new Intrigue();
      $form = $this->createForm(new IntrigueType(), $intrigue);
      $form->bind($request);

      if ($form->isValid()) {
        //ManyToMany handling
        $intrigue->setEvents($intrigue->getEvents(), true);
        foreach ($intrigue->getPlot()->getDatas() as $key => $data) {
          $data->setDocuments($data->getDocuments(), true);
        }
        $this->get('urbicande.intrigue_manager')->saveIntrigue($intrigue);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une intrigue', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('create', 'L‘intrigue a été créée');
        return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $intrigue->getId())));
      }

      return $this->render('UrbicandeIntrigueBundle:Intrigue:new.html.twig', array(
          'intrigue' => $intrigue,
          'form'   => $form->createView(),
      ));
    }

    /**
     * Displays a form to edit an existing Intrigue entity.
     *
     */
    public function editAction($id)
    {
      $intrigue = $this->get('urbicande.intrigue_manager')->loadIntrigue($id);

      if (!$intrigue) {
          throw $this->createNotFoundException('Unable to find Intrigue entity.');
      }

      $editForm = $this->createForm(new IntrigueType(), $intrigue);

      return $this->render('UrbicandeIntrigueBundle:Intrigue:edit.html.twig', array(
          'intrigue'      => $intrigue,
          'form'   => $editForm->createView(),
      ));
    }

    /**
     * Edits an existing Intrigue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
      $intrigue = $this->get('urbicande.intrigue_manager')->loadIntrigue($id);

      if (!$intrigue) {
          throw $this->createNotFoundException('Unable to find Intrigue entity.');
      }

      $editForm = $this->createForm(new IntrigueType(), $intrigue);
      $editForm->bind($request);

      if ($editForm->isValid()) {
          $intrigue->setEvents($intrigue->getEvents());
          foreach ($intrigue->getPlot()->getDatas() as $key => $data) {
            $data->setDocuments($data->getDocuments(), true);
          }
          $this->get('urbicande.intrigue_manager')->saveIntrigue($intrigue);

          $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une intrigue', $this->container->getParameter('supervisor_email'));
          $this->get('session')->getFlashBag()->add('update', 'L‘intrigue a été mise à jour');
          return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $id)));
      }

      return $this->render('UrbicandeIntrigueBundle:Intrigue:edit.html.twig', array(
          'intrigue'      => $intrigue,
          'form'   => $editForm->createView(),
      ));
    }

    /**
     * Deletes a Intrigue entity.
     *
     */
    public function deleteAction($id)
    {
      $intrigue = $this->get('urbicande.intrigue_manager')->loadIntrigue($id);

      if (!$intrigue) {
          throw $this->createNotFoundException('Unable to find Intrigue entity.');
      }

      $this->get('urbicande.intrigue_manager')->removeIntrigue($intrigue);
      
      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé une intrigue', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('delete', 'L‘intrigue a été supprimée');
      return $this->redirect($this->generateUrl('intrigue_list'));
    }

}
